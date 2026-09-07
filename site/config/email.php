<?php

return [
    /**
     * Remitente por defecto de los avisos internos.
     * Debe ser una dirección del propio dominio: si se pone la del
     * visitante, SPF/DKIM la rechazan y el correo acaba en spam.
     */
    'presets' => [
        'notification' => [
            'from' => env('MAIL_FROM_ADDRESS', 'no-reply@framelab.mx'),
            'fromName' => env('MAIL_FROM_NAME', 'Frame Lab'),
        ],
    ],

    'transport' => [
        'type' => env('MAIL_TYPE', 'mail'),
        'host' => env('MAIL_HOST', 'smtp.server.com'),
        'port' => env('MAIL_PORT', 465),
        'auth' => env('MAIL_AUTH', false),
        'username' => env('MAIL_USERNAME', ''),
        'password' => env('MAIL_PASSWORD', ''),
        'security' => env('MAIL_ENCRYPTION', 'tls'),
    ],
];
