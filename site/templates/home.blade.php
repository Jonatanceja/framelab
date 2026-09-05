@php
    /**
     * @var Kirby\Cms\App $kirby
     * @var Kirby\Cms\Page $page
     * @var Kirby\Cms\Site $site
     */
    $ogImage = $page->ogImage()->toFile() ?? $page->heroImage()->toFile();
@endphp

<x-layout
    :title="$page->metaTitle()->or($page->title())->value()"
    :description="$page->metaDescription()->value()"
    :image="$ogImage?->url()"
>
    @include('sections.hero')
    @include('sections.about')
    @include('sections.bootcamp')
    @include('sections.courses')
    @include('sections.testimonials')
    @include('sections.cta')
</x-layout>
