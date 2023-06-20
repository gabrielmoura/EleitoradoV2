<?php

namespace App\Service\Enum;

enum DemandOptions
{
    const PRIORITY_LOW = 'low';

    const PRIORITY_MEDIUM = 'medium';

    const PRIORITY_HIGH = 'high';

    const STATUS_OPEN = 'open';

    const STATUS_CLOSED = 'closed';

    const PRIORITY = [
        self::PRIORITY_LOW,
        self::PRIORITY_MEDIUM,
        self::PRIORITY_HIGH,
    ];

    const STATUS = [
        self::STATUS_OPEN,
        self::STATUS_CLOSED,
    ];

    public static function getPriorityOption(?string $priority): string
    {
        return match ($priority) {
            self::PRIORITY_LOW => 'Baixa',
            self::PRIORITY_MEDIUM => 'Média',
            self::PRIORITY_HIGH => 'Alta',
            default => 'Não informado',
        };
    }

    public static function getStatusOption(?string $status): string
    {
        return match ($status) {
            self::STATUS_OPEN => 'Aberto',
            self::STATUS_CLOSED => 'Fechado',
            default => 'Não informado',
        };
    }
}
