<?php

namespace App\ServiceHttp\UTalk\Endpoints;

trait HasMessage
{
    public function message(): Message
    {
        return new Message();
    }
}
