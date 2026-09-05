<?php

use Kirby\Cms\Page;
use Kirby\Data\Yaml;

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
