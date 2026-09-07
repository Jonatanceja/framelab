<?php
/**
 * Aviso de suscripción nueva (HTML).
 *
 * @var string $email
 * @var string $date
 * @var int    $total
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
                <p style="margin:6px 0 0;font-size:18px;font-weight:700;color:#fff">Nueva suscripción al boletín</p>
            </td>
        </tr>
        <tr>
            <td style="padding:28px">
                <p style="margin:0 0 18px;font-size:20px;font-weight:700">
                    <a href="mailto:<?= esc($email) ?>" style="color:#cf2f6f;text-decoration:none"><?= esc($email) ?></a>
                </p>

                <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px;line-height:1.6">
                    <tr>
                        <td style="padding:6px 0;color:#6b6478;width:150px">Fecha</td>
                        <td style="padding:6px 0"><?= esc($date) ?></td>
                    </tr>
                    <tr>
                        <td style="padding:6px 0;color:#6b6478">Total de suscriptores</td>
                        <td style="padding:6px 0;font-weight:600"><?= (int) $total ?></td>
                    </tr>
                </table>

                <p style="margin:24px 0 0;font-size:13px;color:#6b6478;line-height:1.6">
                    La lista completa está en el <a href="<?= esc($panel) ?>" style="color:#cf2f6f">panel</a>, en Inicio → Suscriptores.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
