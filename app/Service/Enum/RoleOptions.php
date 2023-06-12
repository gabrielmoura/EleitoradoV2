<?php

namespace App\Service\Enum;

enum RoleOptions
{
    const ADMIN = 'admin';

    const USER = 'user';

    const MANAGER = 'manager';

    public static function getRoleOption(?string $role): string
    {
        return match ($role) {
            self::ADMIN => 'Administrador',
            self::MANAGER => 'Gerente',
            self::USER => 'Usuário',
            default => 'Não informado',
        };
    }

    public static function getRoleOptions(): array
    {
        return [
            'Administrador' => self::ADMIN,
            'Gerente' => self::MANAGER,
            'Usuário' => self::USER,
        ];
    }
}
