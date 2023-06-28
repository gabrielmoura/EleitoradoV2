<?php

namespace App\Http\Controllers;

use App\Events\Dash\User\UserBannedEvent;
use App\Events\Export\PDF\ExportedPeopleAddress;
use App\Events\Export\PDF\FailedExportPeopleAddress;
use App\Jobs\Export\PDF\ExportPeopleAddressJob;
use App\Models\Person;
use App\Models\User;
use App\Repositories\AnalyticsRepository;
use App\ServiceHttp\CepService\CepService;
use Illuminate\Bus\Batch;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class AjaxController extends Controller
{
    public function __construct(private readonly AnalyticsRepository $analyticsRepository)
    {
    }

    public function getCep(Request $request): JsonResponse
    {
        $this->validate($request, ['cep' => 'min:8|max:9']);

        return response()->json(CepService::find($request->input('cep')));
    }

    public function requestReportGroup(Request $request): JsonResponse
    {
        if (RateLimiter::tooManyAttempts('export-pdf:' . $request->user()->id, $perMinute = 1)) {
            abort(Response::HTTP_TOO_MANY_REQUESTS, 'Too Many Attempts.');
        }
        $this->validate($request, [
            'group_name' => ['required', 'string', 'max:150'],
            'district' => ['nullable', 'string', 'max:150'],
            'checked' => ['nullable', 'boolean'],
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

        $data->chunk(100)->each(fn($item) => $batch->add(new ExportPeopleAddressJob(
            data: $item,
            filename: 'puxada',
            company_id: $company_id,
            group_by_name: $request->input('group_name')
        )));
        RateLimiter::hit('export-pdf:' . $request->user()->id);

        return response()->json(['batch' => $batch->id]);
    }

    public function checkPersonToGroup(Request $request): JsonResponse
    {
        $this->validate($request, [
            'personId' => ['required', 'string', 'max:20'],
            'groupId' => ['required', 'string', 'max:20'],
        ]);
        $personId = $request->input('personId');
        $groupId = $request->input('groupId');
        try {
            Person::find($personId)->groups()->updateExistingPivot($groupId, [
                'checked_at' => now(),
                'checked_by' => auth()->user()->id,
            ]);
        } catch (\Throwable $throwable) {
            report($throwable);

            return response()->json(['message' => 'error']);
        }

        return response()->json(['message' => 'ok']);
    }

    public function unCheckPersonToGroup(Request $request): JsonResponse
    {
        $this->validate($request, [
            'personId' => ['required', 'string', 'max:20'],
            'groupId' => ['required', 'string', 'max:20'],
        ]);
        $personId = $request->input('personId');
        $groupId = $request->input('groupId');
        try {
            Person::find($personId)->groups()->detach($groupId);
        } catch (\Throwable $throwable) {
            report($throwable);

            return response()->json(['message' => 'error']);
        }

        return response()->json(['message' => 'ok']);
    }

    public function banUser(Request $request): JsonResponse
    {
        $this->validate($request, [
            'userId' => ['required', 'int'],
        ]);
        try {
            $userId = $request->input('userId');
            $user = User::tenant()->findOrFail($userId);
            $user->update(['banned_at' => now()]);

            event(new UserBannedEvent($user));

            return response()->json(['message' => 'ok']);
        } catch (\Throwable $throwable) {
            report($throwable);

            return response()->json(['message' => 'error']);
        }

    }

    public function unBanUser(Request $request): JsonResponse
    {
        $this->validate($request, [
            'userId' => ['required', 'int'],
        ]);
        try {
            $userId = $request->input('userId');
            $user = User::tenant()->findOrFail($userId);
            $user->update(['banned_at' => null]);

            return response()->json(['message' => 'ok']);
        } catch (\Throwable $throwable) {
            report($throwable);

            return response()->json(['message' => 'error']);
        }
    }

    public function requestTagEvent(Request $request): JsonResponse
    {
        if (RateLimiter::tooManyAttempts('export-pdf:' . $request->user()->id, $perMinute = 1)) {
            abort(Response::HTTP_TOO_MANY_REQUESTS, 'Too Many Attempts.');
        }
        $request->validate([
            'event_id' => ['required', 'string', 'max:150'],
        ]);
        $event_id = $request->input('event_id');
        $tenant_id = session()->get('tenant_id');
        $company_id = session()->get('company.id');

        $batch = Bus::batch([])->then(function (Batch $batch) use ($company_id) {
            // Event for Success
        })->catch(function (Batch $batch, \Throwable $e) use ($company_id) {
            // Event for Failed
        })->name('Export People Address')->dispatch();

        RateLimiter::hit('export-pdf:' . $request->user()->id);
        return response()->json(['batch' => $batch->id]);
    }
}
