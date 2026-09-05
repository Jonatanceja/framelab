@php
    /**
     * @var Kirby\Cms\App $kirby
     * @var Kirby\Cms\Page $page
     * @var Kirby\Cms\Site $site
     */
    $ogImage = $page->ogImage()->toFile() ?? $page->introImage()->toFile();
@endphp

<x-layout
    :title="$page->metaTitle()->or($page->title())->value()"
    :description="$page->metaDescription()->value()"
    :image="$ogImage?->url()"
>
    @include('sections.courses-intro')
    @include('sections.courses-grid')
</x-layout>
