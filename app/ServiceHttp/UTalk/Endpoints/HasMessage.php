<?php

namespace App\ServiceHttp\UTalk\Endpoints;

trait HasMessage
{
    public function message(): SendMessage
    {
        return new SendMessage();
    }
}
