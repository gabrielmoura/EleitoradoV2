<?php

namespace App\ServiceHttp\UTalk\Entities;

class Message
{
    public string $_t;

    public string $id;

    public string $createdAtUTC;

    public string $prefix;

    public string $header;

    public string $content;

    public string $footer;

    public string $file;

    public string $thumbnail;

    public array $contacts;

    public string $messageType;

    public SentByOrganizationMember2 $sentByOrganizationMember;

    public bool $isPrivate;

    public string $location;

    public Question2 $question;

    public string $source;

    public string $inReplyTo;

    public string $messageState;

    public string $eventAtUTC;

    public string $chat;

    public string $fromContact;

    public string $templateId;

    public array $buttons;

    public string $botInstance;

    public function __construct(array $data)
    {
        $this->_t = data_get($data, '_t');
        $this->id = data_get($data, 'id');
        $this->createdAtUTC = data_get($data, 'createdAtUTC');
        $this->prefix = data_get($data, 'prefix');
        $this->header = data_get($data, 'header');
        $this->content = data_get($data, 'content');
        $this->footer = data_get($data, 'footer');
        $this->file = data_get($data, 'file');
        $this->thumbnail = data_get($data, 'thumbnail');
        $this->contacts = data_get($data, 'contacts');
        $this->messageType = data_get($data, 'messageType');
        $this->sentByOrganizationMember = data_get($data, 'sentByOrganizationMember');
        $this->isPrivate = data_get($data, 'isPrivate');
        $this->location = data_get($data, 'location');
        $this->question = data_get($data, 'question');
        $this->source = data_get($data, 'source');
        $this->inReplyTo = data_get($data, 'inReplyTo');
        $this->messageState = data_get($data, 'messageState');
        $this->eventAtUTC = data_get($data, 'eventAtUTC');
        $this->chat = data_get($data, 'chat');
        $this->fromContact = data_get($data, 'fromContact');
        $this->templateId = data_get($data, 'templateId');
        $this->buttons = data_get($data, 'buttons');
        $this->botInstance = data_get($data, 'botInstance');
    }
}
