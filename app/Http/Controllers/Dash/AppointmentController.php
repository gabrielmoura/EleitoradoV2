<?php

namespace App\Http\Controllers\Dash;

use App\Features\Appointment as AppointmentFeature;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Address;
use App\Models\Appointment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Pennant\Feature;
use Symfony\Component\HttpFoundation\Response;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(Feature::active(AppointmentFeature::class), Response::HTTP_UNAUTHORIZED);

        return view('dash.appointments.index');
    }

    public function ajax(Request $request): JsonResponse
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date',
        ]);
        $events = Appointment::where('start_time', '>=', $request->start)
            ->orWhere('end_time', '<=', $request->end)->get()
            ->collect()->map(fn ($appointment) => [
                'title' => $appointment->name,
                'start' => $appointment->start_time,
                'end' => $appointment->finish_time,
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dash.appointments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {
        $app = DB::transaction(function () use ($request) {
            $address = Address::create([
                'zipcode' => $request->zipcode,
                'district' => $request->district,
                'street' => $request->street,
                'number' => $request->number,
                'complement' => $request->complement,
                'city' => $request->city,
                'state' => $request->state,
            ]);

            return Appointment::create([
                'name' => $request->name,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'description' => $request->description,
                'address_id' => $address->id,
            ]);
        }, 2);

        if ($app->wasRecentlyCreated) {
            flash()->addSuccess('Agendamento criado com sucesso!');

            return to_route('dash.appointments.index');
        }
        flash()->addWarning('Erro ao criar agendamento!');

        return back()->withErrors(['error' => 'Erro ao criar agendamento!']);
    }

    /**
     * Display the specified resource.
     */
    public function show($pid)
    {
        $appointment = Appointment::wherePid($pid)->first();
        //        $googleMaps = 'https://www.google.com/maps/search/?api=1&query=' . $appointment->address->latitude . ',' . $appointment->address->longitude;
        //        $address = $appointment->address?->street . ', ' . $appointment->address?->number . ' - ' . $appointment->address?->district . ', ' . $appointment->address?->city . ' - ' . $appointment->address?->uf;
        //Deverá conter Editar e Excluir

        return view('dash.appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        return view('dash.appointments.edit', compact('appointment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
