<?php

namespace App\ServiceHttp\UTalk\Entities;

class Member
{

    public string $displayName;

    public string $emailAddress;

    public string $signature;

    public string $timeZone;

    public string $cellphone;

    public string $messageEndChat;

    public string $profilePictureUrl;

    public string $statusActivity;

    public array $organizations;

    public string $umblerAccountId;

    public string $id;

    public string $createdAtUTC;

    public function __construct(array $data)
    {
        $this->displayName = data_get($data, 'displayName');
        $this->emailAddress = data_get($data, 'emailAddress');
        $this->signature = data_get($data, 'signature');
        $this->timeZone = data_get($data, 'timeZone');
        $this->cellphone = data_get($data, 'cellphone');
        $this->messageEndChat = data_get($data, 'messageEndChat');
        $this->profilePictureUrl = data_get($data, 'profilePictureUrl');
        $this->statusActivity = data_get($data, 'statusActivity');
        $this->organizations = data_get($data, 'organizations');
        $this->umblerAccountId = data_get($data, 'umblerAccountId');
        $this->id = data_get($data, 'id');
        $this->createdAtUTC = data_get($data, 'createdAtUTC');
    }
}
