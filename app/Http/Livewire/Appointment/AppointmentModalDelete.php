<?php

namespace App\Http\Livewire\Appointment;

use App\Models\Appointment;
use Livewire\Component;

class AppointmentModalDelete extends Component
{
    public Appointment $appointment;
    public string $modalId = 'appointment-modal-delete';
    protected $listeners = ['refresh' => '$refresh'];
    public function closeModal(): void
    {
        $this->emit('refresh');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function delete(): void
    {
        $this->appointment->delete();
        $this->emitUp('refresh');
        $this->redirect(route('dash.appointment.index'));
    }

    public function render()
    {
        return view('livewire.appointment.appointment-modal-delete');
    }
}
