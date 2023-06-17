<?php

namespace App\ServiceHttp\UTalk\Endpoints;

trait HasChannel
{
    public function channel(): Channel
    {
        return new Channel();
    }
}
