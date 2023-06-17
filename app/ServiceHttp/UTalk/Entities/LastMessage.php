<?php

namespace App\ServiceHttp\UTalk\Entities;

class LastMessage
{
    public ?string $prefix;

    public string $content;

    public array $contacts;

    public string $messageType;

    public ?array $sentByOrganizationMember;

    public bool $isPrivate;

    public string $source;

    public string $messageState;

    public string $eventAtUTC;

    public array $chat;

    public array $buttons;

    public string $id;

    public string $createdAtUTC;

    public function __construct(array $data)
    {
        $this->prefix = data_get($data, 'Prefix', null);
        $this->content = data_get($data, 'Content');
        $this->contacts = data_get($data, 'Contacts');
        $this->messageType = data_get($data, 'MessageType');
        $this->sentByOrganizationMember = data_get($data, 'SentByOrganizationMember');
        $this->isPrivate = data_get($data, 'IsPrivate');
        $this->source = data_get($data, 'Source');
        $this->messageState = data_get($data, 'MessageState');
        $this->eventAtUTC = data_get($data, 'EventAtUTC');
        $this->chat = data_get($data, 'Chat');
        $this->buttons = data_get($data, 'Buttons');
        $this->id = data_get($data, 'Id');
        $this->createdAtUTC = data_get($data, 'CreatedAtUTC');
    }

    /**
     * Retorna o remetente da mensagem (Contact|Member)
     *
     * @return string (Contact|Member)
     */
    public function getSource(): string
    {
        return $this->source;
    }
}
