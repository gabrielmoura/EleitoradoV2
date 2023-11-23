<?php

namespace App\Http\Livewire\Group;

use App\Models\Group;
use App\Service\Trait\Table\WithBulkActions;
use App\Service\Trait\Table\WithReordering;
use App\Service\Trait\Table\WithSearch;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use AuthorizesRequests;
    use WithBulkActions;
    use WithPagination;
    use WithReordering;
    use WithSearch;

    public string $name;

    public ?string $description;

    public $perPage = 10;

    public array $bulkActions = [
        'exportSelected' => 'Export',
    ];

    public ?int $updateGroupId;

    protected $rules = [
        'name' => ['required', 'string', 'min:3', 'max:255'],
        'description' => ['nullable', 'string', 'min:3', 'max:255'],
    ];

    protected $listeners = ['refresh' => '$refresh'];

    protected $paginationTheme = 'bootstrap';

    public function delete($id): void
    {
        $this->authorize('delete_group');
        Group::findOrFail($id)->delete();
        flash()->addSuccess('Grupo deletado com sucesso.');
        $this->emit('refresh');
    }

    public function exportSelected()
    {
        dd($this->selected, $this->selectAll);
    }

    // edit function
    public function update(): void
    {
        $this->authorize('update_group');
        $group = Group::findOrFail($this->updateGroupId);
        $group->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);
        flash()->addSuccess('Grupo atualizado com sucesso.');
        $this->closeModal();
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
        $this->updateGroupId = null;
    }

    public function edit(int $id): void
    {
        $group = Group::findOrFail($id);

        $this->name = $group->name;
        $this->description = $group->description;
        $this->updateGroupId = $group->id;
    }

    public function store(): void
    {
        $this->authorize('create_group');
        $validatedData = $this->validate();
        $validatedData['tenant_id'] = session()->get('tenant_id');
        $group = Group::create($validatedData);
        $this->emit('groupStored', $group->id);
        flash()->addSuccess('Grupo criado com sucesso.');
        $this->closeModal();
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function render(): Application|Factory|View
    {
        return view('livewire.group.index', [
            'groups' => Group::search($this->search)
                ->orderBy($this->defaultReorderColumn, $this->defaultReorderASC ? 'asc' : 'desc')
                ->paginate($this->perPage),
        ]);
    }
}
