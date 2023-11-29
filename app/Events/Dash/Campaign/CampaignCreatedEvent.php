<?php

namespace App\Events\Dash\Campaign;

use App\Jobs\Send\Campaign\SendDirectMailCampaignJob;
use App\Jobs\Send\Campaign\SendEmailCampaignJob;
use App\Jobs\Send\Campaign\SendSmsCampaignJob;
use App\Jobs\Send\Campaign\SendWhatsappCampaignJob;
use App\Models\Campaign;
use App\Service\Enum\CampaignOptions;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Throwable;

class CampaignCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @throws Throwable
     */
    public function __construct(public Campaign $model)
    {
        $batch = Bus::batch([])->name('Campaign');

        switch ($this->model->channel) {
            case CampaignOptions::CHANNEL_EMAIL:
                $batch->add(new SendEmailCampaignJob($this->model));
                break;
            case CampaignOptions::CHANNEL_SMS:
                $batch->add(new SendSmsCampaignJob($this->model));
                break;
            case CampaignOptions::CHANNEL_WHATSAPP:
                $batch->add(new SendWhatsappCampaignJob($this->model));
                break;
            case CampaignOptions::CHANNEL_PUSH:
                $batch->add(new SendDirectMailCampaignJob($this->model));
                break;
        }

        $batch = $batch->dispatch();
        $this->model->batch_id = $batch->id;
        $this->model->save();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
