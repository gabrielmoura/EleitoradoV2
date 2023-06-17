<?php

namespace App\ServiceHttp\UTalk\Entities;

class Channel
{
    public string $phoneNumber;

    public string $state;
    public string $channelType;

    public string $platform;

    public string $name;

    public string $id;

    public function __construct(array $data)
    {
        $this->phoneNumber = data_get($data, 'phoneNumber');
        $this->state = data_get($data, 'state');
        $this->channelType = data_get($data, 'channelType');
        $this->platform = data_get($data, 'platform');
        $this->name = data_get($data, 'name');
        $this->id = data_get($data, 'id');
    }
}
