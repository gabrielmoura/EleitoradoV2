<?php

namespace App\ServiceHttp\UTalk\Endpoints;

trait HasSector
{
    public function sector(): Sector
    {
        return new Sector();
    }
}
