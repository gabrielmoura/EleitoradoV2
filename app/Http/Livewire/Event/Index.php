<?php

namespace App\Http\Livewire\Event;

use App\Models\Event;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public string $name;

    public string|null $description;

    public string $start_date;

    public string|null $end_date;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'created_at';

    public $orderAsc = true;

    public int|null $updateEventId;

    public $selectedItems = [];

    protected $rules = [
        'name' => ['required', 'string', 'min:3', 'max:255'],
        'description' => ['nullable', 'string', 'min:3', 'max:255'],
        'start_date' => ['required', 'date'],
        'end_date' => ['nullable', 'date'],
    ];

    protected $listeners = ['refresh' => '$refresh'];

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.event.index',
            [
                'events' => Event::where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%'.$this->search.'%')
                    ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
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
        $this->start_date = '';
        $this->end_date = '';
        $this->updateEventId = null;
    }

    public function closeModal(): void
    {
        $this->emit('refresh');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
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

    public function setSelect($id): void
    {
        $this->selectedItems[] = $id;
    }

    public function exportSelected($to): void
    {
        $this->emit('exportSelected', $to, $this->selectedItems);
    }

    /**
     * CUD functions
     */
    public function store(): void
    {
        $this->authorize('create_event');
        $validatedData = $this->validate();
        $validatedData['tenant_id'] = session()->get('tenant_id');
        $event = Event::create($validatedData);
        $this->emit('groupStored', $event->id);
        flash()->addSuccess('Event successfully created.');
        $this->closeModal();
    }

    public function update(): void
    {
        $this->authorize('update_event');
        $event = Event::findOrFail($this->updateEventId);
        $event->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);
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
    }
}
