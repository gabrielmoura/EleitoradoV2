<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\CampaignStoreRequest;
use App\Models\Campaign;
use App\Service\Enum\CampaignOptions;
use Illuminate\Support\Facades\Bus;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class CampaignController extends Controller
{
    public function index()
    {
        return view('dash.campaign.index');
    }

    public function create()
    {
        return view('dash.campaign.create', [
            'channels' => CampaignOptions::CHANNELS,
            'toTypes' => CampaignOptions::TO_TYPE,
        ]);
    }

    public function attributes(): array
    {
        return [
            'title' => 'Título', 'description' => 'Descrição', 'message' => 'Mensagem', 'status' => 'Status', 'url' => 'URL', 'to_id' => 'Destinatário', 'to_type' => 'Tipo de Destinatário', 'channel' => 'Canal', 'meta' => 'Meta', 'file' => 'Arquivo',
        ];
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function store(CampaignStoreRequest $request)
    {
        $batch = Bus::batch([])->name('Campaign')->dispatch();

        $data = [
            'batch_id' => $batch->id,
            'to_id' => $request->to_id,
            'to_type' => $request->to_type,
            'channel' => $request->channel,
            'title' => $request->title,
            'description' => $request->description,
            'message' => $request->message,
            'url' => $request->url,
        ];

        $campaign = Campaign::create($data);
        if ($campaign->wasRecentlyCreated && $request->hasFile('file')) {
            $campaign->addMediaFromRequest('file')->toMediaCollection('campaign');
        }
        if ($campaign->wasRecentlyCreated) {
            flash()->addSuccess('Campanha criada com sucesso');
            redirect()->route('dash.campaign.index');
        }
        flash()->addWarning('Não foi possível criar a campanha');

    }

    public function show(Campaign $campaign)
    {
        //
    }
}
