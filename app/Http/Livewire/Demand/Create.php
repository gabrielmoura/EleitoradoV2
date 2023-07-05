<?php

namespace App\Http\Livewire\Demand;

use App\Models\Demand;
use App\Models\DemandType;
use App\Models\Person;
use App\Service\Enum\DemandOptions;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Create extends Component
{
    use AuthorizesRequests;

    public string $name;

    public ?string $description;

    public string $priority;

    public bool $active = true;

    public ?int $demand_type_id;

    public string $status;

    public ?string $solution_date;

    public ?string $closed_at;

    public int|null $updateDemandId;

    public ?Person $person;

    public function mount(): void
    {
        $this->priority = DemandOptions::PRIORITY_LOW;
        $this->active = true;
        $this->status = DemandOptions::STATUS_OPEN;
    }

    protected $rules = [
        'name' => ['required', 'string', 'min:3', 'max:255'],
        'description' => ['nullable', 'string', 'min:3', 'max:255'],
        'priority' => ['nullable', 'string', 'min:3', 'in:low,medium,high'],
        'active' => ['nullable', 'bool'],
        'demand_type_id' => ['required', 'integer', 'min:1', 'exists:demand_types,id'],
        'status' => ['nullable', 'string', 'min:3', 'in:open,closed'],
        'solution_date' => ['nullable', 'string', 'min:3', 'max:255'],
        'closed_at' => ['nullable', 'string', 'min:3', 'max:255'],
        //        'person_id' => ['nullable', 'integer', 'min:1', 'exists:people,id'],
    ];

    protected $listeners = ['refresh' => '$refresh'];

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName, $this->rules);
    }

    public function closeModal(): void
    {
        $this->emit('refresh');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    private function resetInput(): void
    {
        $this->name = '';
        $this->description = '';
        $this->priority = DemandOptions::PRIORITY_LOW;
        $this->active = true;
        $this->status = DemandOptions::STATUS_OPEN;
        $this->solution_date = '';
        $this->closed_at = null;

        $this->demand_type_id = null;
        $this->updateDemandId = null;
    }

    public function render()
    {
        return view('livewire.demand.create', [
            'demandTypes' => DemandType::all(),
        ]);
    }

    public function store(): void
    {
        $this->authorize('create_demand', Demand::class);

        $validatedData = $this->validate();
        $demand = Demand::create($validatedData);

        if ($this->person) {
            $demand->persons()->attach($this->person->id);
        }

        if ($demand->wasRecentlyCreated) {
            $this->dispatchBrowserEvent('close-modal');
            $this->emit('refresh');
            $this->resetInput();
            $this->closeModal();
            flash()->addSuccess('Demanda criada com sucesso.');
        }
    }
}
