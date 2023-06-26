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

    public string $name;

    public ?string $description;

    public ?string $start_date;

    public ?string $end_date;

    public ?string $street;

    public ?string $number;

    public ?string $complement;

    public ?string $district;

    public ?string $city;

    public ?string $state;

    public ?string $zipcode;

    public $perPage = 10;

    public $orderBy = 'created_at';

    public $orderAsc = true;

    public int|null $updateEventId;

    public $selectedItems = [];

    protected $rules = [
        'name' => ['required', 'string', 'min:3', 'max:255'],
        'description' => ['nullable', 'string', 'min:3', 'max:255'],
        'start_date' => ['required', 'date'],
        'end_date' => ['nullable', 'date'],
        'street' => ['nullable', 'string', 'min:3', 'max:255'],
        'number' => ['nullable', 'string', 'min:1', 'max:10'],
        'complement' => ['nullable', 'string', 'min:3', 'max:255'],
        'district' => ['nullable', 'string', 'min:3', 'max:255'],
        'city' => ['nullable', 'string', 'min:3', 'max:255'],
        'state' => ['nullable', 'string', 'min:3', 'max:255'],
        'zipcode' => ['nullable', 'string', 'min:3', 'max:10'],
    ];

    protected $listeners = ['refresh' => '$refresh'];

    protected $paginationTheme = 'bootstrap';

    public function render(): View|Factory|Application
    {
        return view('livewire.event.index',
            [
                'events' => Event::where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%'.$this->search.'%')
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
        $this->name = '';
        $this->description = '';
        $this->start_date = null;
        $this->end_date = null;
        $this->updateEventId = null;
        $this->street = '';
        $this->number = '';
        $this->complement = '';
        $this->district = '';
        $this->city = '';
        $this->state = '';
        $this->zipcode = '';
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
        $validatedData = $this->validate();

        $event = DB::transaction(function () use ($validatedData) {
            if ($this->zipcode >= 8) {
                $address = Address::create($validatedData);
                $validatedData['address_id'] = $address->id;
            }

            return Event::create($validatedData);
        });

        $this->emit('groupStored', $event->id);
        flash()->addSuccess('Event successfully created.');
        $this->closeModal();
    }

    public function update(): void
    {
        $this->authorize('update_event');
        $validatedData = $this->validate();

        DB::transaction(function () use ($validatedData) {
            $event = Event::find($this->updateEventId);
            Address::find($event->address_id)->update($validatedData);

            return $event->update($validatedData);
        });

        flash()->addSuccess('Evento atualizado com sucesso.');
        $this->closeModal();
    }

    public function delete($id): void
    {
        $this->authorize('delete_event');
        Event::find($id)->delete();
        session()->flash('message', 'Group successfully deleted.');
    }

    public function edit(int $id): void
    {
        $event = Event::findOrFail($id);

        $this->name = $event->name;
        $this->description = $event->description;
        $this->updateEventId = $event->id;
        $this->start_date = $event->start_date;
        $this->end_date = $event->end_date;
        $this->street = $event->address->street;
        $this->number = $event->address->number;
        $this->complement = $event->address->complement;
        $this->district = $event->address->district;
        $this->city = $event->address->city;
        $this->state = $event->address->state;
        $this->zipcode = $event->address->zipcode;
    }

    public function getCep(): void
    {
        if ($this->zipcode >= 8 || $this->zipcode <= 9) {
            $cep = CepService::find($this->zipcode);
            $this->street = $cep->logradouro;
            $this->district = $cep->bairro;
            $this->city = $cep->localidade;
            $this->state = $cep->uf;
        }
    }
}
