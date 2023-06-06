<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Controle de Permissões
    |--------------------------------------------------------------------------
    |
    | This option allows you to add additional Artisan commands that should
    | be available within the Tinker environment. Once the command is in
    | this array you may execute the command in Tinker using its name.
    |
    */
    'cache' => [
        'enabled' => env('PERMISSION_CACHE_ENABLED', true),
        'store' => 'default',
        'expiration' => 60 * 60 * 24, // 24 hours
        'prefix' => 'permission_',
        'forget_on_refresh' => true,
    ],

];
