<?php

namespace App\Http\Controllers\Dash;

use App\Features\Appointment as AppointmentFeature;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Pennant\Feature;
use Symfony\Component\HttpFoundation\Response;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(! Feature::for($request->user())->active(AppointmentFeature::class), Response::HTTP_UNAUTHORIZED);

        return view('dash.appointments.index');
    }

    public function ajax(Request $request): JsonResponse
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date',
        ]);
        $events = Appointment::whereBetween('start_time', [$request->start, $request->end])->get()
            ->collect()->map(fn ($appointment) => [
                'title' => $appointment->name,
                'start' => $appointment->start_time?->toDateTimeString(),
                'end' => $appointment->finish_time?->toDateTimeString(),
                'description' => $appointment->description,
                'url' => route('dash.appointment.show', $appointment->pid),
                'backgroundColor' => $appointment->finish_time && $appointment->finish_time < now() ? '#f56954' : '#3c8dbc',
                //                'editable' => true,
                //                    'backgroundColor' => '#f56954',
                //                    'borderColor' => '#f56954',
                //                    'textColor' => '#fff',
                //                    extendedProps: {
                //                    status: 'done'
                //                    }
            ]);

        return response()->json($events);
    }

    /**
     * Display the specified resource.
     */
    public function show($pid)
    {
        $appointment = Appointment::with('address')->where('pid', $pid)->firstOrFail();

        return view('dash.appointments.show', compact('appointment'));
    }
}
