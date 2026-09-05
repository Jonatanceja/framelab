<?php

use Kirby\Http\Response;
use Kirby\Toolkit\Str;
use Kirby\Toolkit\V;

/**
 * Endpoints de los formularios públicos.
 *
 * Los envíos se guardan como structure en la página correspondiente:
 * el newsletter en el home (tab Suscriptores) y los mensajes en
 * contacto (tab Mensajes). Ver site/config/helpers.php.
 */
return [
    [
        'pattern' => 'suscripcion',
        'method' => 'POST',
        'action' => function () {
            $data = kirby()->request()->data();

            if (csrf($data['csrf'] ?? null) !== true) {
                return Response::json(['ok' => false, 'message' => 'Sesión expirada, recarga la página.'], 403);
            }

            // Trampa para bots: si viene llena, fingimos éxito.
            if (! empty($data['website'])) {
                return Response::json(['ok' => true]);
            }

            $email = Str::lower(trim((string) ($data['email'] ?? '')));

            if (V::email($email) === false) {
                return Response::json(['ok' => false, 'message' => 'Escribe un correo válido.'], 400);
            }

            $home = site()->homePage();

            $exists = $home->subscribers()->toStructure()
                ->filter(fn ($item) => Str::lower($item->email()->value()) === $email)
                ->isNotEmpty();

            if ($exists === false) {
                $stored = framelab_store_submission($home, 'subscribers', [
                    'date' => date('Y-m-d H:i'),
                    'email' => $email,
                ]);

                if ($stored === false) {
                    return Response::json(['ok' => false, 'message' => 'No pudimos guardar tu correo, inténtalo más tarde.'], 500);
                }
            }

            return Response::json(['ok' => true]);
        },
    ],

    [
        'pattern' => 'mensaje',
        'method' => 'POST',
        'action' => function () {
            $data = kirby()->request()->data();

            if (csrf($data['csrf'] ?? null) !== true) {
                return Response::json(['ok' => false, 'message' => 'Sesión expirada, recarga la página.'], 403);
            }

            if (! empty($data['website'])) {
                return Response::json(['ok' => true]);
            }

            $name = trim((string) ($data['name'] ?? ''));
            $email = Str::lower(trim((string) ($data['email'] ?? '')));
            $course = trim((string) ($data['course'] ?? ''));
            $message = trim((string) ($data['message'] ?? ''));

            if (Str::length($name) < 2) {
                return Response::json(['ok' => false, 'message' => 'Escribe tu nombre.'], 400);
            }

            if (V::email($email) === false) {
                return Response::json(['ok' => false, 'message' => 'Escribe un correo válido.'], 400);
            }

            $contact = page('contacto');

            if ($contact === null) {
                return Response::json(['ok' => false, 'message' => 'El formulario no está disponible.'], 500);
            }

            $stored = framelab_store_submission($contact, 'messages', [
                'date' => date('Y-m-d H:i'),
                'name' => Str::short($name, 100),
                'email' => $email,
                'course' => Str::short($course, 120),
                'message' => Str::short($message, 2000),
            ]);

            if ($stored === false) {
                return Response::json(['ok' => false, 'message' => 'No pudimos enviar tu mensaje, inténtalo más tarde.'], 500);
            }

            return Response::json(['ok' => true]);
        },
    ],
];
