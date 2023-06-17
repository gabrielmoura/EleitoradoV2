<?php

namespace App\ServiceHttp\UTalk\Endpoints;

trait HasWebhook
{
    public function webhook(): Webhook
    {
        return new Webhook();
    }
}
