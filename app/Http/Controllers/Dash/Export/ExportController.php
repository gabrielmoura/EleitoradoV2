<?php

namespace App\Http\Controllers\Dash\Export;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Support\Facades\Bus;
use Spatie\MediaLibrary\Support\MediaStream;

class ExportController extends Controller
{
    public function status()
    {

        $batchId = request('id');

        return Bus::findBatch($batchId);

    }

    public function response(string $name, string $id): MediaStream
    {
        $company = Company::find(session()->get('company.id'));
        $company->notifications->where('data->uid', $id)->first()?->markAsRead();
        $custom = $company->getMedia(strtolower($name), ['batchId' => $id]);

        return MediaStream::create($id . '.zip')->addMedia($custom);
    }
}
