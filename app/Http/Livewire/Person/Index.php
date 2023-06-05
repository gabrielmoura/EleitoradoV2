<?php

namespace App\Http\Livewire\Person;

use App\Models\Person;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public string $name;

    public string|null $description;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'created_at';

    public $orderAsc = true;

    public int|null $updatePersonId;

    public $selectedItems = [];

    protected $rules = [
        'name' => ['required', 'string', 'min:3', 'max:255'],
        'description' => ['nullable', 'string', 'min:3', 'max:255'],
    ];

    protected $listeners = ['refresh' => '$refresh'];

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.person.index');
    }

    public function setSelect($id): void
    {
        $this->selectedItems[] = $id;
    }

    public function exportSelected($to): void
    {
        $this->emit('exportSelected', $to, $this->selectedItems);
    }

    public function sortBy($field): void
    {
        if ($this->orderBy === $field) {
            $this->orderAsc = ! $this->orderAsc;
        } else {
            $this->orderAsc = true;
        }
        $this->orderBy = $field;
    }

    public function closeModal(): void
    {
        $this->emit('refresh');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    private function resetInput(): void
    {
        $this->name = '';
        $this->description = '';
        $this->updatePersonId = null;
    }

    // CRUD functions
    public function edit(int $id): void
    {
        $group = Person::findOrFail($id);

        $this->name = $group->name;
        $this->description = $group->description;
        $this->updatePersonId = $group->id;
    }

    public function store(): void
    {
        $this->authorize('create_person');
        $validatedData = $this->validate();
        $validatedData['tenant_id'] = session()->get('tenant_id');
        $group = Person::create($validatedData);
        $this->emit('groupStored', $group->id);
        flash()->addSuccess('Group successfully created.');
        $this->closeModal();
    }

    public function update(): void
    {
        $this->authorize('update_person');
        $group = Person::findOrFail($this->updatePersonId);
        $group->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);
        $this->closeModal();
    }

    public function delete($id): void
    {
        $this->authorize('delete_person');
        Person::find($id)->delete();
        session()->flash('message', 'Group successfully deleted.');
    }
}
