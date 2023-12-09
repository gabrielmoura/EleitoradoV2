<?php

namespace App\Http\Livewire\Appointment;

use App\Models\Address;
use App\Models\Appointment;
use Gabrielmoura\LaravelCep\Cep;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AppointmentCreate extends Component
{
    public array $app = [];

    public function render(): Application|Factory|View
    {
        return view('livewire.appointment.appointment-create');
    }

    public function closeModal(): void
    {
        //        $this->emit('refresh');
        $this->dispatchBrowserEvent('close-modal');
        $this->app = [];
    }

    public function getCep(): void
    {
        $zipCode = $this->app['address']['zipcode'];
        if (preg_match('/^[0-9]{5}-?[0-9]{3}$/', $zipCode)) {
            $cep = Cep::find($zipCode);
            $this->app['address']['street'] = $cep->logradouro;
            $this->app['address']['district'] = $cep->bairro;
            $this->app['address']['city'] = $cep->localidade;
            $this->app['address']['state'] = $cep->uf;
        }
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function startTimeChanged($value): void
    {
        $this->app['event']['start_time'] = $value;
    }

    protected $listeners = [
        'refresh' => '$refresh',
        'startTimeChanged' => 'startTimeChanged',
    ];

    protected $rules = [
        'app.event.name' => ['required', 'string', 'min:3', 'max:255'],
        'app.event.description' => ['nullable', 'string', 'min:3', 'max:255'],
        'app.event.start_time' => ['required', 'date', 'after:today'],
        'app.event.end_time' => ['nullable', 'date', 'after:app.event.start_time'],
        //        'app.event.recurrence' => ['nullable', 'string', 'in:none,daily,weekly,monthly'],

        'app.address.street' => ['nullable', 'string', 'min:3', 'max:255'],
        'app.address.number' => ['nullable', 'numeric', 'min_digits:1', 'max_digits:5'],
        'app.address.complement' => ['nullable', 'string', 'min:3', 'max:255'],
        'app.address.district' => ['nullable', 'string', 'min:3', 'max:255'],
        'app.address.city' => ['nullable', 'string', 'min:3', 'max:255'],
        'app.address.state' => ['nullable', 'string', 'min:2', 'max:255'],
        'app.address.zipcode' => ['required', 'string', 'min:8', 'max:9', 'regex:/^[0-9]{5}-?[0-9]{3}$/'],
    ];

    protected $validationAttributes = [
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

    public function store(): void
    {

        $this->validate();

        $db = DB::transaction(function () {
            if (preg_match('/^[0-9]{5}-?[0-9]{3}$/', $this->app['address']['zipcode'])) {

                $address = Address::create($this->app['address']);
                $this->app['event']['address_id'] = $address->id;
            }

            return Appointment::create($this->app['event']);
        });
        if ($db->wasRecentlyCreated) {
            flash()->addSuccess('Agendamento criado com sucesso.');
            $this->emit('saved');
            $this->reset('app');
            $this->emitUp('refresh');
            $this->closeModal();
        } else {
            flash()->addWarning('Erro ao criar agendamento!');
        }

    }
}
