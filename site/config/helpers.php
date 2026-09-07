<?php

use Kirby\Cms\Page;
use Kirby\Data\Yaml;
use Kirby\Toolkit\V;

if (! function_exists('framelab_store_submission')) {
    /**
     * Agrega una entrada a un campo de tipo structure de una página.
     *
     * Se usa para guardar los envíos del formulario de contacto y las altas
     * del newsletter dentro del panel, en la página que les corresponde.
     */
    function framelab_store_submission(Page $page, string $field, array $entry): bool
    {
        $kirby = kirby();

        try {
            $items = $page->content()->get($field)->yaml();
            $items[] = $entry;

            $kirby->impersonate('kirby');
            $page->update([$field => Yaml::encode($items)]);

            return true;
        } catch (Throwable $e) {
            error_log('framelab_store_submission: '.$e->getMessage());

            return false;
        } finally {
            $kirby->impersonate(null);
        }
    }
}

if (! function_exists('framelab_notify')) {
    /**
     * Envía un aviso por correo al equipo.
     *
     * Nunca lanza excepciones: el envío es secundario y el registro ya
     * quedó guardado en el contenido, así que un fallo de SMTP no debe
     * romper el formulario ni perder el dato. Los errores van al log.
     *
     * @param  string  $template  Plantilla en site/templates/emails
     * @param  array  $data  Variables de la plantilla
     * @param  array  $options  Claves extra para el email (p. ej. replyTo)
     */
    function framelab_notify(string $template, string $subject, array $data, array $options = []): bool
    {
        $site = site();

        if ($site->notifyEnabled()->toBool(true) === false) {
            return false;
        }

        $to = trim((string) ($options['to'] ?? ''));

        if ($to === '' || V::email($to) === false) {
            return false;
        }

        unset($options['to']);

        try {
            kirby()->email('notification', array_merge([
                'to' => $to,
                'subject' => $subject,
                'template' => $template,
                'data' => $data,
            ], $options));

            return true;
        } catch (Throwable $e) {
            // El correo es secundario: se registra y se sigue.
            error_log('framelab_notify ['.$template.']: '.$e->getMessage());

            return false;
        }
    }
}
