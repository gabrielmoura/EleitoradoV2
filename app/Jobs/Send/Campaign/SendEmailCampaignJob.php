<?php

namespace App\Jobs\Send\Campaign;

use App\Mail\Dash\CampaignMail;
use App\Models\Campaign;
use App\Service\Enum\CampaignOptions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailCampaignJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Campaign $campaign)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $model = $this->campaign->to_type::find($this->campaign->to_id);

        match ($this->campaign->to_type) {
            CampaignOptions::TO_TYPE_PERSON => $this->sendToPerson($model),
            CampaignOptions::TO_TYPE_GROUP => $this->sendToGroup($model),
        };
        $this->campaign->update(['status' => CampaignOptions::STATUS_SENT]);
    }

    protected function sendToPerson($model): void
    {
        Mail::to($model->email)->send(new CampaignMail($this->campaign));
    }

    protected function sendToGroup($model): void
    {
        foreach ($model->people as $person) {
            Mail::to($person->email)->send(new CampaignMail($this->campaign));
        }
    }
}
