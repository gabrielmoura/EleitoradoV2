<?php

namespace App\Http\Livewire\Event;

use App\Models\Address;
use App\Models\Event;
use App\Service\Trait\Table\WithReordering;
use App\Service\Trait\Table\WithSearch;
use App\ServiceHttp\CepService\CepService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    use WithReordering;
    use WithSearch;

    public $data;

    public $perPage = 10;

    public $orderBy = 'created_at';

    public $orderAsc = true;

    public ?int $updateEventId;

    public $selectedItems = [];

    protected $rules = [
        'data.event.name' => ['required', 'string', 'min:3', 'max:255'],
        'data.event.description' => ['nullable', 'string', 'min:3', 'max:255'],
        'data.event.start_date' => ['required', 'date'],
        'data.event.end_date' => ['nullable', 'date'],

        'data.local.street' => ['nullable', 'string', 'min:3', 'max:255'],
        'data.local.number' => ['nullable', 'string', 'min:1', 'max:10'],
        'data.local.complement' => ['nullable', 'string', 'min:3', 'max:255'],
        'data.local.district' => ['nullable', 'string', 'min:3', 'max:255'],
        'data.local.city' => ['nullable', 'string', 'min:3', 'max:255'],
        'data.local.state' => ['nullable', 'string', 'min:3', 'max:255'],
        'data.local.zipcode' => ['nullable', 'string', 'min:8', 'max:9', 'regex:/^[0-9]{5}-?[0-9]{3}$/']
    ];
    protected $casts = [
        'data.event.start_date' => 'datetime:Y-m-d H:i:s',
        'data.event.end_date' => 'datetime:Y-m-d H:i:s',
    ];

    protected array $validationAttributes = [
        'data.event.name' => 'Nome',
        'data.event.description' => 'Descrição',
        'data.event.start_date' => 'Data de início',
        'data.event.end_date' => 'Data de término',

        'data.local.street' => 'Rua',
        'data.local.number' => 'Número',
        'data.local.complement' => 'Complemento',
        'data.local.district' => 'Bairro',
        'data.local.city' => 'Cidade',
        'data.local.state' => 'Estado',
        'data.local.zipcode' => 'CEP',
    ];

    protected $listeners = ['refresh' => '$refresh'];

    protected string $paginationTheme = 'bootstrap';

    public function render(): View|Factory|Application
    {
        return view('livewire.event.index',
            [
                'events' => Event::where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orderBy($this->defaultReorderColumn, $this->defaultReorderASC ? 'asc' : 'desc')
                    ->paginate($this->perPage),
            ]);
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    private function resetInput(): void
    {
        $this->data = [];
        $this->updateEventId = null;
    }

    public function closeModal(): void
    {
        $this->emit('refresh');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    /**
     * CUD functions
     */
    public function store(): void
    {
        $this->authorize('create_event');
        $validatedData = $this->validate()['data'];

        $event = DB::transaction(function () use ($validatedData) {

            if (preg_match('/^[0-9]{5}-?[0-9]{3}$/', $validatedData['local']['zipcode'])) {
                $address = Address::create($validatedData['local']);
                $validatedData['event']['address_id'] = $address->id;
            }

            return Event::create($validatedData['event']);
        });

        $this->emit('groupStored', $event->id);
        flash()->addSuccess('Evento criado com sucesso.');
        $this->closeModal();
    }

    public function update(): void
    {
        $this->authorize('update_event');
        $validatedData = $this->validate()['data'];

        DB::transaction(function () use ($validatedData) {
            $event = Event::find($this->updateEventId);
            Address::find($event->address_id)->update($validatedData['local']);

            return $event->update($validatedData['event']);
        });

        flash()->addSuccess('Evento atualizado com sucesso.');
        $this->closeModal();
    }

    public function delete($id): void
    {
        $this->authorize('delete_event');
        Event::find($id)->delete();
        flash()->addSuccess('Evento excluído com sucesso.');
    }

    public function edit(int $id): void
    {
        $this->updateEventId = $id;
        $event = Event::with('address')->findOrFail($id);
        $this->data['event'] = $event->toArray();
        $this->data['event']['start_date'] = $event->start_date->format('Y-m-d\TH:i');
        $this->data['event']['end_date'] = $event->end_date->format('Y-m-d\TH:i');
        $this->data['local'] = $event->address;
        $this->data['local']['number'] = strval($event->address?->number);
    }


    public function getCep(): void
    {
        $zipCode = $this->data['local']['zipcode'];
        if (preg_match('/^[0-9]{5}-?[0-9]{3}$/', $zipCode)) {
            $cep = CepService::find($zipCode);
            $this->data['local']['street'] = $cep->logradouro;
            $this->data['local']['district'] = $cep->bairro;
            $this->data['local']['city'] = $cep->localidade;
            $this->data['local']['state'] = $cep->uf;
        }
    }
}
