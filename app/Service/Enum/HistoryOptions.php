<?php

namespace App\Service\Enum;

enum HistoryOptions
{
    /**
     * @return string[]
     */
    public static function getStatusOptions(): array
    {
        return [
            'Criado' => 'created', // created
            'Atualizado' => 'updated', // updated
            'Deletado' => 'deleted', // deleted
        ];
    }

    public static function getStatusOption(?string $status): string
    {
        return match ($status) {
            'created' => 'Criado',
            'updated' => 'Atualizado',
            'deleted' => 'Deletado',
            default => 'Não informado',
        };
    }

    public static function getAttributeOption(?string $attribute): string
    {
        return match ($attribute) {
            'attributes' => 'Novos Dados',
            'old' => 'Dados Antigos',
            default => 'Não informado',
        };
    }
}
