@php
    /**
     * @var Kirby\Cms\App $kirby
     * @var Kirby\Cms\Page $page
     * @var Kirby\Cms\Site $site
     */
    $ogImage = $page->ogImage()->toFile() ?? $page->photo()->toFile();
@endphp

<x-layout
    :title="$page->metaTitle()->or($page->title())->value()"
    :description="$page->metaDescription()->or($page->tagline())->value()"
    :image="$ogImage?->url()"
>
    @include('sections.teacher-profile')
</x-layout>
