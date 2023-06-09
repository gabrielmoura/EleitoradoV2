<?php

namespace App\ServiceHttp\UTalk\Entities;

class Chat
{
    //{
    //  "_t": "string",
    //  "id": "1234abcd5678EFGH",
    //  "createdAtUTC": "2023-06-07T21:26:38.334Z",
    //  "organization": {},
    //  "contact": {
    //    "lastActiveUTC": "2023-06-07T21:26:38.334Z",
    //    "phoneNumber": "string",
    //    "profilePictureUrl": "https://example.com",
    //    "isOptIn": true,
    //    "isBlocked": true,
    //    "scheduledMessages": [
    //      {
    //        "status": "string",
    //        "deleted": true,
    //        "channelReference": "string"
    //      }
    //    ],
    //    "groupIdentifier": "string",
    //    "tags": [
    //      {
    //        "_t": "string"
    //      },
    //      {
    //        "emoji": "string",
    //        "color": "string",
    //        "order": 0,
    //        "createdAtUTC": "2023-06-07T21:26:38.334Z"
    //      }
    //    ]
    //  },
    //  "channel": {
    //    "phoneNumber": "string",
    //    "state": "string",
    //    "channelType": "string",
    //    "platform": "string"
    //  },
    //  "sector": {
    //    "default": true,
    //    "order": 0
    //  },
    //  "organizationMember": {
    //    "_t": "string",
    //    "id": "1234abcd5678EFGH",
    //    "muted": true
    //  },
    //  "organizationMembers": [
    //    {
    //      "_t": "string",
    //      "id": "1234abcd5678EFGH",
    //      "muted": true
    //    },
    //    {
    //      "_t": "string",
    //      "muted": true,
    //      "displayName": "string",
    //      "emailAddress": "string",
    //      "statusActivity": "string",
    //      "profilePictureUrl": "https://example.com",
    //      "permissions": [
    //        "Member"
    //      ],
    //      "allowedSector": "string",
    //      "allowedChannel": "string",
    //      "active": true,
    //      "lastBotTransferenceUTC": "2023-06-07T21:26:38.334Z"
    //    }
    //  ],
    //  "tags": [
    //    {
    //      "_t": "string",
    //      "name": "string"
    //    },
    //    {
    //      "_t": "string",
    //      "emoji": "string",
    //      "color": "string",
    //      "order": 0,
    //      "createdAtUTC": "2023-06-07T21:26:38.334Z"
    //    }
    //  ],
    //  "lastMessage": {
    //    "prefix": "string",
    //    "header": "string",
    //    "content": "string",
    //    "footer": "string",
    //    "file": "string",
    //    "thumbnail": "string",
    //    "contacts": [
    //      {
    //        "name": "string",
    //        "addresses": [
    //          {
    //            "addressLine1": "string",
    //            "addressLine2": "string",
    //            "city": "string",
    //            "state": "string",
    //            "zipCode": "string",
    //            "country": "string"
    //          }
    //        ],
    //        "phoneNumbers": [
    //          "string"
    //        ],
    //        "company": "string",
    //        "emails": [
    //          "string"
    //        ],
    //        "profilePictureBlob": "string"
    //      }
    //    ],
    //    "messageType": "string",
    //    "sentByOrganizationMember": {
    //      "_t": "string",
    //      "muted": true
    //    },
    //    "isPrivate": true,
    //    "location": "string",
    //    "question": {
    //      "_t": "string",
    //      "id": "1234abcd5678EFGH",
    //      "key": "string"
    //    },
    //    "source": "string",
    //    "inReplyTo": "string",
    //    "messageState": "string",
    //    "eventAtUTC": "2023-06-07T21:26:38.334Z",
    //    "chat": "string",
    //    "fromContact": "string",
    //    "templateId": "1234abcd5678EFGH",
    //    "buttons": [
    //      {
    //        "text": "string",
    //        "type": "string",
    //        "phoneNumber": "string",
    //        "url": "string",
    //        "variable": "string"
    //      }
    //    ],
    //    "botInstance": "string"
    //  },
    //  "redactReason": "PrivatedBySomeoneElse",
    //  "open": true,
    //  "private": true,
    //  "waiting": true,
    //  "unread": [
    //    "1234abcd5678EFGH"
    //  ],
    //  "closedAtUTC": "2023-06-07T21:26:38.334Z",
    //  "eventAtUTC": "2023-06-07T21:26:38.334Z",
    //  "hasMessagesBeforeAllowedHistory": true,
    //  "latestMessages": [
    //    {
    //      "_t": "string",
    //      "id": "1234abcd5678EFGH",
    //      "createdAtUTC": "2023-06-07T21:26:38.334Z",
    //      "prefix": "string",
    //      "header": "string",
    //      "content": "string",
    //      "footer": "string",
    //      "file": "string",
    //      "thumbnail": "string",
    //      "contacts": [
    //        {
    //          "name": "string",
    //          "addresses": [
    //            {
    //              "addressLine1": "string",
    //              "addressLine2": "string",
    //              "city": "string",
    //              "state": "string",
    //              "zipCode": "string",
    //              "country": "string"
    //            }
    //          ],
    //          "phoneNumbers": [
    //            "string"
    //          ],
    //          "company": "string",
    //          "emails": [
    //            "string"
    //          ],
    //          "profilePictureBlob": "string"
    //        }
    //      ],
    //      "messageType": "string",
    //      "sentByOrganizationMember": {
    //        "_t": "string",
    //        "muted": true
    //      },
    //      "isPrivate": true,
    //      "location": "string",
    //      "question": {
    //        "_t": "string",
    //        "id": "1234abcd5678EFGH",
    //        "key": "string"
    //      },
    //      "source": "string",
    //      "inReplyTo": "string",
    //      "messageState": "string",
    //      "eventAtUTC": "2023-06-07T21:26:38.334Z",
    //      "chat": "string",
    //      "fromContact": "string",
    //      "templateId": "1234abcd5678EFGH",
    //      "buttons": [
    //        {
    //          "text": "string",
    //          "type": "string",
    //          "phoneNumber": "string",
    //          "url": "string",
    //          "variable": "string"
    //        }
    //      ],
    //      "botInstance": "string"
    //    }
    //  ]
    //}

    public readonly string $id;

    public readonly string $createdAtUTC;

    public readonly Organization $organization;

    public readonly Contact $contact;

    public readonly Channel $channel;

    public readonly Sector $sector;

    public readonly OrganizationMember $organizationMember;

    public readonly array $organizationMembers;

    public readonly array $tags;

    public readonly LastMessage $lastMessage;

    public readonly string $redactReason;

    public readonly bool $open;

    public readonly bool $private;

    public readonly bool $waiting;

    public readonly array $unread;

    public readonly string $closedAtUTC;

    public readonly string $eventAtUTC;

    public readonly bool $hasMessagesBeforeAllowedHistory;

    public readonly array $latestMessages;

    public function __construct(array $data)
    {
        $this->id = data_get($data, 'id');
        $this->createdAtUTC = data_get($data, 'createdAtUTC');
        $this->organization = new Organization(data_get($data, 'organization'));
        $this->contact = new Contact(data_get($data, 'contact'));
        $this->channel = new Channel(data_get($data, 'channel'));
        $this->sector = new Sector(data_get($data, 'sector'));
        $this->organizationMember = new OrganizationMember(data_get($data, 'organizationMember'));
        $this->organizationMembers = array_map(function ($item) {
            return new OrganizationMember($item);
        }, data_get($data, 'organizationMembers', []));
        $this->tags = array_map(function ($item) {
            return new Tag($item);
        }, data_get($data, 'tags', []));
        $this->lastMessage = new LastMessage(data_get($data, 'lastMessage'));
        $this->redactReason = data_get($data, 'redactReason');
        $this->open = data_get($data, 'open');
        $this->private = data_get($data, 'private');
        $this->waiting = data_get($data, 'waiting');
        $this->unread = data_get($data, 'unread', []);
        $this->closedAtUTC = data_get($data, 'closedAtUTC');
        $this->eventAtUTC = data_get($data, 'eventAtUTC');
        $this->hasMessagesBeforeAllowedHistory = data_get($data, 'hasMessagesBeforeAllowedHistory');
        $this->latestMessages = array_map(function ($item) {
            return new Message($item);
        }, data_get($data, 'latestMessages', []));
    }
}
