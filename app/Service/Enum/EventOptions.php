<?php

namespace App\Service\Enum;

enum EventOptions
{
    const RECURRENCE_RADIO = [
        'none' => 'Nenhum',
        'daily' => 'Diário',
        'weekly' => 'Semanal',
        'monthly' => 'Mensal',
        'yearly' => 'Anual',
    ];
}
