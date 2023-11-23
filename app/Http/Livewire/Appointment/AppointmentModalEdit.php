<?php

namespace App\Http\Livewire\Appointment;

use App\Models\Address;
use App\Models\Appointment;
use App\ServiceHttp\CepService\CepService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AppointmentModalEdit extends Component
{
    public Appointment $appointment;

    public array $app = [];

    protected $listeners = ['refresh' => '$refresh'];

    public string $modalId = 'appointment-modal-edit';

    protected array $rules = [
        'app.event.name' => ['required', 'string', 'min:3', 'max:255'],
        'app.event.description' => ['nullable', 'string', 'min:3', 'max:255'],
        'app.event.start_time' => ['required', 'date'],
        'app.event.end_time' => ['nullable', 'date'],
        //        'app.event.recurrence' => ['nullable', 'string', 'in:none,daily,weekly,monthly'],

        'app.address.street' => ['nullable', 'string', 'min:3', 'max:255'],
        'app.address.number' => ['nullable', 'numeric', 'min_digits:1', 'max_digits:5'],
        'app.address.complement' => ['nullable', 'string', 'min:3', 'max:255'],
        'app.address.district' => ['nullable', 'string', 'min:3', 'max:255'],
        'app.address.city' => ['nullable', 'string', 'min:3', 'max:255'],
        'app.address.state' => ['nullable', 'string', 'min:2', 'max:255'],
        'app.address.zipcode' => ['nullable', 'string', 'min:8', 'max:9', 'regex:/^[0-9]{5}-?[0-9]{3}$/'],
    ];

    protected array $validationAttributes = [
        'app.event.name' => 'Nome',
        'app.event.description' => 'Descrição',
        'app.event.start_time' => 'Data de início',
        'app.event.end_time' => 'Data de término',
        'app.address.street' => 'Rua',
        'app.address.number' => 'Número',
        'app.address.complement' => 'Complemento',
        'app.address.district' => 'Bairro',
        'app.address.city' => 'Cidade',
        'app.address.state' => 'Estado',
        'app.address.zipcode' => 'CEP',
    ];

    public function render()
    {
        return view('livewire.appointment.appointment-modal-edit');
    }

    public function mount(): void
    {
        $this->app['event'] = $this->appointment?->toArray();
        $this->app['event']['start_time'] = $this->appointment?->start_time?->format('Y-m-d\TH:i');
        $this->app['event']['end_time'] = $this->appointment?->end_time?->format('Y-m-d\TH:i');
        $this->app['address'] = $this->appointment?->address?->toArray();
    }

    private function resetInput(): void
    {
        $this->mount();
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
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
        $db = DB::transaction(function () {
            if (preg_match('/^[0-9]{5}-?[0-9]{3}$/', $this->app['address']['zipcode'])) {
                $addr = Address::updateOrCreate(['id' => $this->appointment->address_id], $this->app['address']);
                $this->app['event']['address_id'] = $addr->id;
            }
            $this->appointment->update($this->app['event']);
        });
        if ($db->wasRecentlyCreated) {
            flash()->addSuccess('Agendamento atualizado com sucesso.');
            $this->emitUp('refresh');
            $this->closeModal();
            $this->redirect(route('appointments.show', ['appointment' => $this->appointment->id]));
        } else {
            flash()->addWarning('Erro ao atualizar agendamento!');
        }
    }

    public function getCep(): void
    {
        $zipCode = $this->app['address']['zipcode'];
        if (preg_match('/^[0-9]{5}-?[0-9]{3}$/', $zipCode)) {
            $cep = CepService::find($zipCode);
            $this->app['address']['street'] = $cep->logradouro;
            $this->app['address']['district'] = $cep->bairro;
            $this->app['address']['city'] = $cep->localidade;
            $this->app['address']['state'] = $cep->uf;
        }
    }
}
