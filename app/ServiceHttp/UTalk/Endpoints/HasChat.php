<?php

namespace App\ServiceHttp\UTalk\Endpoints;

trait HasChat
{
    public function chat(): Chat
    {
        return new Chat();
    }
}
