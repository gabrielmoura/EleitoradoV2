<?php

namespace App\Http\Livewire\Campaign;

use App\Models\Campaign;
use App\Service\Enum\CampaignOptions;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class CreateCampaign extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['refresh' => '$refresh'];

    public $errors;

    public ?array $data = [];

    public function render()
    {
        return view('livewire.campaign.create-campaign', [
            'channels' => CampaignOptions::CHANNELS,
            'toTypes' => CampaignOptions::TO_TYPE,
        ]);
    }

    public function updated($propertyName)
    {
        return $this->validateOnly(
            $propertyName,
            $this->rules(),
            $this->messages(),
            $this->validationAttributes()
        );
    }

    public function save(): void
    {

        $campaign = Campaign::create($this->data);

        if ($campaign->wasRecentlyCreated && isset($this->data['file'])) {
            $campaign->addMediaFromRequest('file')->toMediaCollection('campaign');
        }

        if ($campaign->wasRecentlyCreated) {
            flash()->addSuccess('Campanha criada com sucesso');
            redirect()->route('dash.campaign.index');
        } else {
            flash()->addWarning('Não foi possível criar a campanha');
        }
    }

    public function rules(): array
    {
        return [
            'data.title' => 'required|string|min:3', 'data.description' => 'nullable|string', 'data.message' => ['required', 'string'], 'data.status' => ['required', 'string', 'in:'.implode(',', array_values(CampaignOptions::STATUS))], 'data.url' => ['nullable', 'string', 'url'], 'data.to_id' => ['required', 'integer'], 'data.to_type' => ['required', 'string', 'in:'.implode(',', array_values(CampaignOptions::TO_TYPE))], 'data.channel' => ['required', 'string', 'in:'.implode(',', array_values(CampaignOptions::CHANNELS))], 'data.meta' => ['nullable', 'array'], 'data.file' => ['nullable', 'file', 'mimes:pdf,doc,docx,odt,txt,image/jpeg,image/png,image/jpg,image/webp'],
        ];
    }

    public function messages(): array
    {
        return [
            'data.title.required' => 'O campo Título é obrigatório.', 'data.title.min' => 'O campo Título deve ter no mínimo 3 caracteres.', 'data.description.required' => 'O campo Descrição é obrigatório.', 'data.message.required' => 'O campo Mensagem é obrigatório.', 'data.status.required' => 'O campo Status é obrigatório.', 'data.url.required' => 'O campo URL é obrigatório.', 'data.to_id.required' => 'O campo Destinatário é obrigatório.', 'data.to_type.required' => 'O campo Tipo de Destinatário é obrigatório.', 'data.channel.required' => 'O campo Canal é obrigatório.', 'data.meta.required' => 'O campo Meta é obrigatório.', 'data.file.required' => 'O campo Arquivo é obrigatório.',
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'data.title' => 'Título', 'data.description' => 'Descrição', 'data.message' => 'Mensagem', 'data.status' => 'Status', 'data.url' => 'URL', 'data.to_id' => 'Destinatário', 'data.to_type' => 'Tipo de Destinatário', 'data.channel' => 'Canal', 'data.meta' => 'Meta', 'data.file' => 'Arquivo',
        ];
    }
}
