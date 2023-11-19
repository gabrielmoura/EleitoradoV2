<?php

namespace App\Http\Livewire\Modal;

use App\Events\Export\PDF\RequestExportTagEvent;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

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


    public function mount(): void
    {
        $this->data['event_id'] = $this->event_id ?? null;
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

    public function store(Request $request): void
    {
        $this->validate();
        if (RateLimiter::tooManyAttempts('export-pdf:' . $request->user()->id, $perMinute = 1)) {
            $this->addError('request', 'Muitas tentativas. Tente novamente mais tarde.');
        }
        event(new RequestExportTagEvent(
            tenant_id: session()->get('tenant_id'),
            company_id: session()->get('company.id'),
            event_id: $this->data['event_id'],
            type: $this->data['type'] ?? null,
        ));

        RateLimiter::hit('export-pdf:' . $request->user()->id);

        flash()->addSuccess('Solicitação enviada com sucesso!');
        $this->closeModal();
        $this->emit('refresh');
        $this->emit('refreshBrowser');
    }
}
