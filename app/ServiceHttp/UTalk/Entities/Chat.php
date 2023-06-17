<?php

namespace App\ServiceHttp\UTalk\Entities;

class Chat
{
    public $id;

    public $organization;

    public $contact;

    public $channel;

    public $sector;

    public $organizationMember;

    public $organizationMembers;

    public $tags;

    public $lastMessage;

    public $open;

    public $private;

    public $waiting;

    public $unread;

    public $closedAtUTC;

    public $eventAtUTC;

    public $createdAtUTC;

    public function __construct(array $data)
    {
        $this->id = data_get($data, 'id');
        $this->organization = data_get($data, 'organization');
        $this->contact = data_get($data, 'contact');
        $this->channel = data_get($data, 'channel');
        $this->sector = data_get($data, 'sector');
        $this->organizationMember = data_get($data, 'organizationMember');
        $this->organizationMembers = data_get($data, 'organizationMembers');
        $this->tags = data_get($data, 'tags');
        $this->lastMessage = data_get($data, 'lastMessage');
        $this->open = data_get($data, 'open');
        $this->private = data_get($data, 'private');
        $this->waiting = data_get($data, 'waiting');
        $this->unread = data_get($data, 'unread');
        $this->closedAtUTC = data_get($data, 'closedAtUTC');
        $this->eventAtUTC = data_get($data, 'eventAtUTC');
        $this->createdAtUTC = data_get($data, 'createdAtUTC');
    }
}
