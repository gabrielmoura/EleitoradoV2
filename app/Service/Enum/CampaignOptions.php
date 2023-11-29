<?php

namespace App\Service\Enum;

enum CampaignOptions
{
    /** Channels */
    const CHANNEL_EMAIL = 'email';

    const CHANNEL_SMS = 'sms';

    const CHANNEL_WHATSAPP = 'whatsapp';

    const CHANNEL_PUSH = 'push';

    const CHANNEL_TELEGRAM = 'telegram';

    /** Status  */
    const STATUS_PENDING = 'pending';

    const STATUS_SENT = 'sent';

    const STATUS_ERROR = 'error';

    /** To Type */
    const TO_TYPE_GROUP = \App\Models\Group::class;

    const TO_TYPE_PERSON = \App\Models\Person::class;

    const CHANNELS = [
        'E-mail' => self::CHANNEL_EMAIL,
        'SMS' => self::CHANNEL_SMS,
        'WhatsApp' => self::CHANNEL_WHATSAPP,
        'Push' => self::CHANNEL_PUSH,
        'Telegram' => self::CHANNEL_TELEGRAM,
    ];

    const STATUS = [
        'Pendente' => self::STATUS_PENDING,
        'Enviado' => self::STATUS_SENT,
        'Erro' => self::STATUS_ERROR,
    ];

    const TO_TYPE = [
        'Grupo' => self::TO_TYPE_GROUP,
        'Pessoa' => self::TO_TYPE_PERSON,
    ];
}
