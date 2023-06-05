<?php

namespace App\Http\Controllers\Dash\Export;

use App\Events\Export\PDF\ExportedPeopleAddress;
use App\Events\Export\PDF\FailedExportPeopleAddress;
use App\Http\Controllers\Controller;
use App\Jobs\Export\PDF\ExportPeopleAddressJob;
use App\Models\Company;
use App\Repositories\AnalyticsRepository;
use Illuminate\Bus\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\RateLimiter;
use Spatie\MediaLibrary\Support\MediaStream;

class PeopleAddressController extends Controller
{
    public function __construct(private readonly AnalyticsRepository $analyticsRepository)
    {
    }

    public function request(Request $request)
    {
        if (RateLimiter::tooManyAttempts('export-pdf:'.$request->user()->id, $perMinute = 5)) {
            abort(429, 'Too Many Attempts.');
        }

        $this->validate($request, [
            'group_name' => 'required|string',
            'district' => 'nullable|string',
            'checked' => 'nullable|boolean',
        ]);
        $tenant_id = session()->get('tenant_id');
        $company_id = session()->get('company.id');

        $batch = Bus::batch([])->then(function (Batch $batch) use ($company_id) {
            ExportedPeopleAddress::dispatch($batch->id, $company_id);

        })->catch(function (Batch $batch, \Throwable $e) use ($company_id) {
            FailedExportPeopleAddress::dispatch($batch->id, $company_id, $e->getMessage());
        })->name('Export People Address')->dispatch();

        $data = $this->analyticsRepository->pessoas(
            group_name: $request->input('group_name'),
            tenant_id: $tenant_id,
            district: $request->input('district'),
            checked: $request->input('checked'),
            lazy: false);

        //        foreach ($data->chunk(100) as $item) {
        //            $batch->add(new ExportPeopleAddressJob(
        //                data: $item,
        //                filename: 'puxada',
        //                company_id: $company_id,
        //                group_by_name: $request->input('group_name')
        //            ));
        //        }
        $data->chunk(100)->each(fn ($item) => $batch->add(new ExportPeopleAddressJob(
            data: $item,
            filename: 'puxada',
            company_id: $company_id,
            group_by_name: $request->input('group_name')
        )));

        RateLimiter::hit('export-pdf:'.$request->user()->id);

        return to_route('getBatch', ['id' => $batch->id]);
    }

    public function status()
    {

        $batchId = request('id');

        return Bus::findBatch($batchId);

    }

    public function response($id)
    {
        $company = Company::find(session()->get('company.id'));
        $custom = $company->getMedia('puxada', ['batchId' => $id]);

        return MediaStream::create($id.'.zip')->addMedia($custom);
    }
}
