<?php

namespace App\ServiceHttp\UTalk\Entities;

class Event
{
    public string $type;
    public string $eventDate;
    public PayloadEvent $payload;

    public function __construct(array $data)
    {
        $this->type = data_get($data, 'Type', null);
        $this->eventDate = data_get($data, 'EventDate', null);
        $this->payload = new PayloadEvent(data_get($data, 'Payload', []));
    }

    /**
     * @return string (MemberTransfer,Message)
     */
    public function getType(): string
    {
        return $this->type;
    }

}
