<?php

return [
    /**
     * Todas las miniaturas se generan en WebP.
     *
     * Kirby aplica esto a cualquier thumb (resize, crop, srcset), así que
     * basta con no servir el archivo original: en las plantillas siempre
     * se pide una miniatura a través de partials/media.blade.php.
     */
    'format' => 'webp',
    'quality' => 82,

    'srcsets' => [
        // Imágenes a todo lo ancho (portadas, fondos)
        'default' => [
            '640w' => ['width' => 640],
            '1024w' => ['width' => 1024],
            '1440w' => ['width' => 1440],
            '1920w' => ['width' => 1920],
            '2400w' => ['width' => 2400],
        ],
        // Imágenes dentro de una columna o tarjeta
        'card' => [
            '400w' => ['width' => 400],
            '640w' => ['width' => 640],
            '900w' => ['width' => 900],
            '1200w' => ['width' => 1200],
        ],
    ],
];
