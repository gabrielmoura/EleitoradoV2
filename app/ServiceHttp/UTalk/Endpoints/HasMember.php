<?php

namespace App\ServiceHttp\UTalk\Endpoints;

trait HasMember
{
    public function member(): Member
    {
        return new Member();
    }
}
