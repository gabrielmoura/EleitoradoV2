<?php

namespace App\Http\Livewire\Appointment;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class AppointmentList extends Component
{
    public function render(): Application|Factory|View
    {
        return view('livewire.appointment.appointment-list');
    }
}
