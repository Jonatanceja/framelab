<?php
/**
 * Aviso de mensaje nuevo (texto plano).
 *
 * @var string $name
 * @var string $email
 * @var string $course
 * @var string $message
 * @var string $date
 * @var string $panel
 */
?>
Nuevo mensaje desde el formulario de contacto.

Nombre:  <?= $name ?>

Correo:  <?= $email ?>

Curso:   <?= $course ?: 'No especificado' ?>

Fecha:   <?= $date ?>


Mensaje:
<?= $message ?: '(sin mensaje)' ?>


--
Puedes responder directamente a este correo para contestarle a <?= $name ?>.
Todos los mensajes quedan guardados en el panel: <?= $panel ?>
