<?php

namespace App\Http\Livewire\Appointment;

use App\Models\Appointment;
use Livewire\Component;

class AppointmentModalEdit extends Component
{
    public Appointment $appointment;
    public array $data = [];
    protected $listeners = ['refresh' => '$refresh'];
    public string $modalId = 'appointment-modal-edit';
    protected array $rules = [
        'data.name' => ['nullable', 'string', 'max:255', 'min:3'],
        'data.event_id' => ['nullable'],
        'data.type' => ['nullable'],
        'data.start_time' => ['required', 'date'],
        'data.end_time' => ['nullable', 'date'],
        'data.recurrence' => ['nullable'],
        'data.description' => ['nullable'],
        'data.properties' => ['nullable'],
        'data.address_id' => ['nullable'],
    ];
    protected array $validationAttributes = [
        'data.name' => 'Nome',
        'data.event_id' => 'Evento',
        'data.type' => 'Tipo',
        'data.start_time' => 'Data de início',
        'data.end_time' => 'Data de término',
        'data.recurrence' => 'Recorrência',
        'data.description' => 'Descrição',
        'data.properties' => 'Propriedades',
        'data.address_id' => 'Endereço',
    ];

    public function render()
    {
        return view('livewire.appointment.appointment-modal-edit');
    }

    public function mount()
    {
        $this->data = $this->appointment?->toArray();
    }

    private function resetInput(): void
    {
        $this->assoc = [];
    }

    public function closeModal(): void
    {
        $this->emit('refresh');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function update()
    {
        $this->validate();
        $this->appointment->update($this->data);
        $this->closeModal();
        $this->redirect(route('appointments.show', ['appointment' => $this->appointment->id]));
    }

}
