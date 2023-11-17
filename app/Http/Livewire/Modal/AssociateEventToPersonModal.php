<?php

namespace App\Http\Livewire\Modal;

use App\Models\Event;
use App\Models\Person;
use Livewire\Component;

class AssociateEventToPersonModal extends Component
{
    public Event $event;
    public array $assoc = [];
    protected $listeners = ['refresh' => '$refresh'];

    public function render(): \Illuminate\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.modal.associate-event-to-person-modal',
            [
                'people' => Person::with('address')->get(),
            ]);
    }

    public function store()
    {

        // attach() caso não exista a associação, ele cria, caso exista, ele não duplica
        $this->event->persons()->syncWithoutDetaching($this->assoc);

        $this->emit('peopleAttached', $this->assoc);
        flash()->addSuccess('Pessoa(s) associada(s) com sucesso.\n Recarregue a pagina.', ['timeOut' => 5000], ['title' => 'Sucesso']);
        $this->closeModal();
        $this->emit('refresh');
        $this->emit('refreshBrowser');
    }

    private function resetInput(): void
    {
        $this->assoc = [];
    }

    public function closeModal(): void
    {
        $this->emit('refresh');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }
}
