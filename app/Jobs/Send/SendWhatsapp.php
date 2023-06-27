<?php

namespace App\Jobs\Send;

use App\Models\Company;
use App\ServiceHttp\UTalk\UtalkService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Throwable;

class SendWhatsapp implements ShouldQueue, ShouldBeUnique
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Collection $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data, public Company $company)
    {
        if (array_key_exists('phone', $data)) {
            throw new \Exception('O campo phone é obrigatório');
        }
        if (array_key_exists('message', $data)) {
            throw new \Exception('O campo message é obrigatório');
        }

        if (array_key_exists('phone', $data) && ! str_starts_with($data['phone'], '55')) {
            $data['phone'] = '55'.$data['phone'];
        }
        $this->data = collect($data);
    }

    /**
     * The unique ID of the job.
     */
    public function uniqueId(): string
    {
        return $this->company->id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $utalk = new UtalkService();
        $utalk->message()->set(
            toPhone: $this->data->get('phone'),
            fromPhone: $this->company->config()->get('utalk.phone'),
            organizationId: $this->company->config()->get('utalk.organization_id'),
            message: $this->data->get('message'),
            token: $this->company->config()->get('utalk.key'),
        );
        sleep(1);
    }

    public function failed(Throwable $exception): void
    {
        report($exception);
    }
}
