<?php

namespace App\Http\Controllers;

use App\Events\Dash\User\UserBannedEvent;
use App\Events\Export\PDF\RequestExportPeopleAddressEvent;
use App\Events\Export\PDF\RequestExportTagEvent;
use App\Models\Person;
use App\Models\User;
use Gabrielmoura\LaravelCep\Cep;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class AjaxController extends Controller
{
    public function getCep(Request $request): JsonResponse
    {
        $this->validate($request, ['cep' => 'min:8|max:9|regex:/^[0-9]{5}-?[0-9]{3}$/']);

        return response()->json(Cep::find($request->input('cep')));
    }

    public function requestReportGroup(Request $request): JsonResponse
    {
        if (RateLimiter::tooManyAttempts('export-pdf:'.$request->user()->id, $perMinute = 1)) {
            abort(Response::HTTP_TOO_MANY_REQUESTS, 'Too Many Attempts.');
        }
        $this->validate($request, [
            'group_name' => ['required', 'string', 'max:150'],
            'district' => ['nullable', 'string', 'max:150'],
            'checked' => ['nullable', 'boolean'],
        ]);

        event(new RequestExportPeopleAddressEvent(
            group_name: $request->input('group_name'),
            district: $request->input('district'),
            checked: $request->input('checked'),
            tenant_id: session()->get('tenant_id'),
            company_id: session()->get('company.id'),
        ));

        RateLimiter::hit('export-pdf:'.$request->user()->id);

        return response()->json(['message' => 'ok']);
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
        if (RateLimiter::tooManyAttempts('export-pdf:'.$request->user()->id, $perMinute = 1)) {
            abort(Response::HTTP_TOO_MANY_REQUESTS, 'Too Many Attempts.');
        }
        $request->validate([
            'event_id' => ['required', 'string', 'max:150'],
        ]);

        event(new RequestExportTagEvent(
            tenant_id: session()->get('tenant_id'),
            company_id: session()->get('company.id'),
            event_id: $request->input('event_id'),
        ));
        RateLimiter::hit('export-pdf:'.$request->user()->id);

        return response()->json(['message' => 'ok']);
    }
}
