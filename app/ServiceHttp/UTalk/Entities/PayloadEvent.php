<?php

namespace App\ServiceHttp\UTalk\Entities;

class PayloadEvent
{
    public $type;

    public $content;

    public $organization;

    public $contact;

    public $channel;

    public $sector;

    public $organizationMembers;

    public ?LastMessage $lastMessage;

    public $open;

    public $private;

    public $waiting;

    public $unread;

    public $eventAtUTC;

    public $id;

    public $createdAtUTC;

    public function __construct(array $payload)
    {
        $this->type = data_get($payload, 'Type');
        $this->content = data_get($payload, 'Content');
        $this->organization = data_get($payload, 'Content.Organization');
        $this->contact = data_get($payload, 'Content.Contact');
        $this->channel = data_get($payload, 'Content.Channel');
        $this->sector = data_get($payload, 'Content.Sector');
        $this->organizationMembers = data_get($payload, 'Content.OrganizationMembers');
        $this->lastMessage = data_get($payload, 'Content.LastMessage') ? new LastMessage(data_get($payload, 'Content.LastMessage')) : null;

        $this->open = data_get($payload, 'Content.Open');
        $this->private = data_get($payload, 'Content.Private');
        $this->waiting = data_get($payload, 'Content.Waiting');
        $this->unread = data_get($payload, 'Content.Unread');
        $this->eventAtUTC = data_get($payload, 'Content.EventAtUTC');
        $this->id = data_get($payload, 'Content.Id');
        $this->createdAtUTC = data_get($payload, 'Content.CreatedAtUTC');
    }
}
