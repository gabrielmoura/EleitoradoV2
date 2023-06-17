<?php

namespace App\ServiceHttp\UTalk\Entities;

class Message
{
    public $prefix;

    public $header;

    public $content;

    public $footer;

    public $file;

    public $thumbnail;

    public $contacts;

    public $messageType;

    public $sentByOrganizationMember;

    public $isPrivate;

    public $location;

    public $question;

    public $source;

    public $inReplyTo;

    public $messageState;

    public $eventAtUTC;

    public $chat;

    public $fromContact;

    public $templateId;

    public $buttons;

    public $botInstance;

    public $id;

    public $createdAtUTC;

    public function __construct(array $data)
    {
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
        $this->chat = data_get($data, 'chat'); // Channel ID
        $this->fromContact = data_get($data, 'fromContact');
        $this->templateId = data_get($data, 'templateId');
        $this->buttons = data_get($data, 'buttons');
        $this->botInstance = data_get($data, 'botInstance');
        $this->id = data_get($data, 'id'); // ID CHAT
        $this->createdAtUTC = data_get($data, 'createdAtUTC');
    }
}
