<?php

namespace App\Http\Livewire\Demand;

use App\Models\Demand;
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

    public ?string $priority;

    public ?string $active;

    public ?int $demand_type_id;

    public ?string $status;

    public ?string $solution_date;

    public ?string $closed_at;

    public int|null $updateDemandId;

    public function render()
    {
        return view('livewire.demand.index', [
            'demands' => Demand::search($this->search)
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
        $this->description = '';
        $this->priority = '';
        $this->active = '';
        $this->status = '';
        $this->solution_date = '';
        $this->closed_at = '';

        $this->demand_type_id = null;
        $this->updateDemandId = null;

    }
}
