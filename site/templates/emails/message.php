<?php
/**
 * Aviso de mensaje nuevo (HTML).
 *
 * @var string $name
 * @var string $email
 * @var string $course
 * @var string $message
 * @var string $date
 * @var string $panel
 */
?>
<!doctype html>
<html lang="es">
<body style="margin:0;padding:24px;background:#f4f4f7;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Helvetica,Arial,sans-serif;color:#17141c">
    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="max-width:560px;margin:0 auto;background:#fff;border-radius:12px;overflow:hidden;border:1px solid #e4dfec">
        <tr>
            <td style="padding:20px 28px;background:#17141c">
                <p style="margin:0;font-size:13px;letter-spacing:.14em;text-transform:uppercase;color:#ffa3c8">Frame Lab</p>
                <p style="margin:6px 0 0;font-size:18px;font-weight:700;color:#fff">Nuevo mensaje de contacto</p>
            </td>
        </tr>
        <tr>
            <td style="padding:28px">
                <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px;line-height:1.6">
                    <tr>
                        <td style="padding:6px 0;color:#6b6478;width:90px">Nombre</td>
                        <td style="padding:6px 0;font-weight:600"><?= esc($name) ?></td>
                    </tr>
                    <tr>
                        <td style="padding:6px 0;color:#6b6478">Correo</td>
                        <td style="padding:6px 0"><a href="mailto:<?= esc($email) ?>" style="color:#cf2f6f"><?= esc($email) ?></a></td>
                    </tr>
                    <tr>
                        <td style="padding:6px 0;color:#6b6478">Curso</td>
                        <td style="padding:6px 0"><?= esc($course ?: 'No especificado') ?></td>
                    </tr>
                    <tr>
                        <td style="padding:6px 0;color:#6b6478">Fecha</td>
                        <td style="padding:6px 0"><?= esc($date) ?></td>
                    </tr>
                </table>

                <div style="margin-top:20px;padding:16px 18px;background:#faf9fc;border:1px solid #e4dfec;border-radius:8px;font-size:14px;line-height:1.65;white-space:pre-wrap"><?= esc($message ?: '(sin mensaje)') ?></div>

                <p style="margin:24px 0 0;font-size:13px;color:#6b6478;line-height:1.6">
                    Responde a este correo para contestarle directamente.<br />
                    Todos los mensajes quedan guardados en el <a href="<?= esc($panel) ?>" style="color:#cf2f6f">panel</a>.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
