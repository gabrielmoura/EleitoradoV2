<?php

namespace App\Http\Livewire\Modal;

use App\Events\Export\PDF\RequestExportPeopleAddressEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

/**
 * @description Modal para solicitar relatório de pessoas por grupo
 * Class PullRequestModal
 *
 * @property mixed group_name
 * @property mixed district
 * @property mixed checked
 */
class RequestReportGroupModal extends Component
{
    public ?string $group_name;

    public array $data;

    public string $modalId = 'request-report-group-modal';

    protected $listeners = ['open' => 'showModal'];

    protected array $rules = [
        'data.group_name' => ['required', 'string', 'max:150'],
        'data.district' => ['nullable', 'string', 'max:150', 'min:3', 'in:address,district'],
        'data.checked' => ['nullable', 'boolean'],
    ];

    protected array $validationAttributes = [
        'data.group_name' => 'Nome do grupo',
        'data.district' => 'Bairro',
        'data.checked' => 'Marcado',
    ];

    public function mount(): void
    {
        $this->data['checked'] = true;
        $this->data['group_name'] = $this->group_name;
    }

    public function render()
    {
        return view('livewire.modal.request-report-group-modal', [

        ]);
    }

    public function closeModal(): void
    {
        $this->emit('refresh');
        $this->dispatchBrowserEvent('close-modal');
        $this->data['district'] = null;
    }

    public function store(Request $request): void
    {
        $rateLimit = RateLimiter::tooManyAttempts('export-pdf:'.$request->user()->id, $perMinute = 1);
        if ($rateLimit) {
            $this->addError('request', 'Muitas tentativas. Tente novamente mais tarde.');
        } else {
            // Caso não tenha atingido o limite de tentativas, dispara o evento

            event(new RequestExportPeopleAddressEvent(
                group_name: $this->data['group_name'],
                district: $this->data['district'] ?? null,
                checked: $this->data['checked'],
                tenant_id: session()->get('tenant_id'),
                company_id: session()->get('company.id'),
            ));

            flash()->addSuccess("Solicitação de relatório enviada com sucesso.\n Aguarde alguns minutos e verifique seu e-mail.");

            RateLimiter::hit('export-pdf:'.$request->user()->id);

            $this->closeModal();
            $this->emit('refresh');
            $this->emit('refreshBrowser');
        }
    }
}
