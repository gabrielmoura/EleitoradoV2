<?php

namespace App\Http\Livewire\Modal;

use App\Models\Event;
use App\Models\Person;
use Livewire\Component;

class AssociateEventToPersonModal extends Component
{
    public Event $event;
    public $assoc = [];
    protected $listeners = [
        'refresh' => '$refresh',
        'multiSelectItemAdded' => 'multiSelectItemAdded',
        'store' => 'store'
    ];

    public function render()
    {
        return view('livewire.modal.associate-event-to-person-modal',
            [
                'people' => Person::with('address')->get(),
            ]);
    }

    public function multiSelectItemAdded($value)
    {
        $this->assoc = $value;
    }

    public function mount()
    {
        $this->assoc = $this->event->persons->pluck('id')->toArray();
    }

    public function store()
    {
        // attach() caso não exista a associação, ele cria, caso exista, ele não duplica
        $this->event->persons()->sync($this->assoc);

        $this->emit('peopleAttached', $this->assoc);
        flash()->addSuccess('Pessoa(s) associada(s) com sucesso.\n Recarregue a pagina.', ['timeOut' => 5000], ['title' => 'Sucesso']);
        $this->closeModal();
    }

    private function resetInput(): void
    {
        $this->assoc = [];
    }

    public function closeModal(): void
    {
        $this->emit('refresh');
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('refreshBrowser');
//        $this->resetInput();
    }
}
