@php
    /**
     * @var Kirby\Cms\App $kirby
     * @var Kirby\Cms\Page $page
     * @var Kirby\Cms\Site $site
     */
@endphp

<x-layout
    :title="$page->metaTitle()->or($page->title())->value()"
    :description="$page->metaDescription()->value()"
    :image="$page->ogImage()->toFile()?->url()"
>
    @include('sections.contact-form')
    @include('sections.contact-faq')
</x-layout>
