<?php

namespace App\Http\Livewire\DemandType;

use App\Models\DemandType;
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

    public string|null $responsible;

    public int|null $updateDemandTypeId;

    public function render()
    {
        return view('livewire.demand-type.index', [
            'demandTypes' => DemandType::search($this->search)
                ->orderBy('created_at')
                ->paginate($this->perPage),
        ]);
    }

    protected $rules = [
        'name' => ['required', 'string', 'min:3', 'max:255'],
        'responsible' => ['required', 'string', 'min:3', 'max:255'],
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
        $this->responsible = '';
        $this->updateDemandTypeId = null;
    }

    /**
     * CRUD
     */
    public function store(): void
    {
        $this->authorize('create_demand_type');
        $validatedData = $this->validate();
        //        $validatedData['tenant_id'] = session()->get('tenant_id');
        $group = DemandType::create($validatedData);
        $this->emit('demandTypeStored', $group->id);
        flash()->addSuccess('Demand Type successfully created.');
        $this->closeModal();
    }

    public function update(): void
    {
        $this->authorize('update_demand_type');
        $group = DemandType::findOrFail($this->updateDemandTypeId);
        $group->update([
            'name' => $this->name,
            'responsible' => $this->responsible,
        ]);
        session()->flash('message', 'Demand Type successfully updated.');
        $this->closeModal();
    }

    public function delete($id): void
    {
        $this->authorize('delete_demand_type');
        DemandType::find($id)->delete();
        session()->flash('message', 'Demand Type successfully deleted.');
    }
}
