<?php

namespace App\Http\Livewire\Modal;

use App\Events\Export\PDF\RequestExportTagEvent;
use App\Models\Event;
use Livewire\Component;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * @description Modal para solicitar etiquetas de eventos com endereços
 * Class PullRequestModal
 * @package App\Http\Livewire\Modal
 */
class RequestTagEventModal extends Component
{
    public array $data;
    public ?int $event_id;
    public string $modalId = 'request-tag-event-modal';
    protected $listeners = ['open' => 'showModal'];
    protected array $rules = [
        'data.event_id' => ['required', 'integer', 'max:150'],
        'data.type' => ['nullable', 'string', 'max:150'],
    ];
    protected array $validationAttributes = [
        'data.event_id' => 'Evento',
        'data.type' => 'Tipo',
    ];

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function mount(): void
    {
        $this->data['tenant_id'] = session()?->get('tenant_id');
        $this->data['company_id'] = session()?->get('company.id');
        $this->data['event_id'] = $this->event_id??null;
    }

    public function render()
    {
        return view('livewire.modal.request-tag-event-modal', [
            'events' => Event::all(),
        ]);
    }

    public function closeModal(): void
    {
        $this->emit('refresh');
        $this->dispatchBrowserEvent('close-modal');
        $this->data = [];
    }

    public function store(): void
    {
        $this->validate();
        event(new RequestExportTagEvent(
            tenant_id: $this->data['tenant_id'],
            company_id: $this->data['company_id'],
            event_id: $this->data['event_id'],
        ));
        flash()->addSuccess('Solicitação enviada com sucesso!');
        $this->emit('refresh');

        $this->closeModal();
    }
}
