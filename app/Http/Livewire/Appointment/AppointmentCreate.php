<?php

namespace App\Http\Livewire\Appointment;

use App\Models\Address;
use App\Models\Appointment;
use App\ServiceHttp\CepService\CepService;
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
        $this->emit('refresh');
        $this->dispatchBrowserEvent('close-modal');
        $this->app = [];
    }

    public function getCep(): void
    {
        $zipcode = numberClear($this->app['address']['zipcode']);
        if (
            strlen($zipcode) >= 8 && strlen($zipcode) <= 9
        ) {
            $cep = CepService::find($zipcode);
            $this->app['address']['street'] = $cep->logradouro;
            $this->app['address']['district'] = $cep->bairro;
            $this->app['address']['city'] = $cep->localidade;
            $this->state = $cep->uf;
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
        'app.event.description' => ['required'],
        'app.event.start_time' => ['required', 'date', 'after:now'],
        'app.event.end_time' => ['required', 'date', 'after:app.event.start_time'],
        'app.address.street' => ['required'],
        'app.address.number' => ['required'],
        'app.address.complement' => ['required'],
        'app.address.district' => ['required'],
        'app.address.city' => ['required'],
        'app.address.state' => ['required'],
        'app.address.zipcode' => ['required', 'string', 'min:8', 'max:9'],
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
            $validatedData = collect($this->app);
            if ($validatedData->has('app.address')) {
                $address = Address::create($validatedData['app']['address']);
                $validatedData->put('app.event.address_id', $address?->id);
            }

            return Appointment::create($validatedData['app']['event']);
        });
        if ($db->wasRecentlyCreated) {
            flash()->addSuccess('Agendamento criado com sucesso.');
            $this->emit('saved');
        } else {
            flash()->addWarning('Erro ao criar agendamento!');
        }

        $this->reset('appointment');
    }
}
