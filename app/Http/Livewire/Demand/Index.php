<?php

namespace App\Http\Livewire\Demand;

use App\Models\Demand;
use App\Models\DemandType;
use App\Service\Enum\DemandOptions;
use App\Service\Trait\Table\WithReordering;
use App\Service\Trait\Table\WithSearch;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    use WithReordering;
    use WithSearch;

    //    use WithBulkActions;

    public $perPage = 10;

    public string $name;

    public ?string $description;

    public string $priority;

    public bool $active = true;

    public ?int $demand_type_id;

    public string $status;

    public ?string $solution_date;

    public ?string $closed_at;

    public int|null $updateDemandId;

    public function mount(): void
    {
        $this->priority = DemandOptions::PRIORITY_LOW;
        $this->active = true;
        $this->status = DemandOptions::STATUS_OPEN;
    }

    public function render()
    {
        return view('livewire.demand.index', [
            'demands' => Demand::search($this->search)
                ->orderBy('created_at')
                ->paginate($this->perPage),
            'demandTypes' => DemandType::all(),
        ]);
    }

    protected $rules = [
        'name' => ['required', 'string', 'min:3', 'max:255'],
        'description' => ['nullable', 'string', 'min:3', 'max:255'],
        'priority' => ['nullable', 'string', 'min:3', 'in:low,medium,high'],
        'active' => ['nullable', 'bool'],
        'status' => ['nullable', 'string', 'min:3', 'in:open,closed'],
        'solution_date' => ['nullable', 'string', 'min:3', 'max:255'],
        //date('d/m/Y', strtotime($this->solution_date));
        'closed_at' => ['nullable', 'string', 'min:3', 'max:255'],
        'demand_type_id' => ['required', 'integer', 'min:1', 'exists:demand_types,id'],
    ];

    protected $listeners = ['refresh' => '$refresh'];

    protected $paginationTheme = 'bootstrap';

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

    public function store(): void
    {
        $this->authorize('create_demand', Demand::class);

        //        $this->validate();
        $validatedData = $this->validate();

        $demand = Demand::create($validatedData);
        if ($demand->wasRecentlyCreated) {
            $this->dispatchBrowserEvent('close-modal');
            $this->emit('refresh');
            $this->resetInput();
            $this->closeModal();
            flash()->addSuccess('Demanda criada com sucesso.');
        }
    }

    public function edit(Demand $demand): void
    {
        $this->authorize('update_demand');

        $this->updateDemandId = $demand->id;
        $this->name = $demand->name;
        $this->description = $demand->description;
        $this->priority = $demand->priority;
        $this->active = $demand->active;
        $this->status = $demand->status;
        $this->solution_date = $demand->solution_date;
        $this->closed_at = $demand->closed_at;
        $this->demand_type_id = $demand->demand_type_id;

        //        $this->dispatchBrowserEvent('open-modal');
    }

    public function update(): void
    {
        $this->authorize('update_demand');

        $this->validate();

        $demand = Demand::find($this->updateDemandId);

        $success = $demand->update([
            'name' => $this->name,
            'description' => $this->description,
            'priority' => $this->priority,
            'active' => $this->active,
            'status' => $this->status,
            'solution_date' => $this->solution_date,
            'closed_at' => $this->closed_at,
            'demand_type_id' => $this->demand_type_id,
        ]);
        if ($success) {
            $this->closeModal();
            $this->resetInput();
            flash()->addSuccess('Demanda atualizada com sucesso.');
        }
    }

    public function delete(Demand $demand): void
    {
        $this->authorize('delete_demand');

        $demand->delete();
        $this->emit('refresh');
        flash()->addSuccess('Demanda excluída com sucesso.');
    }
}
