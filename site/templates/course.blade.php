@php
    /**
     * @var Kirby\Cms\App $kirby
     * @var Kirby\Cms\Page $page
     * @var Kirby\Cms\Site $site
     */
    $ogImage = $page->ogImage()->toFile() ?? $page->cardImage()->toFile();
@endphp

<x-layout
    :title="$page->metaTitle()->or($page->title())->value()"
    :description="$page->metaDescription()->or($page->tagline())->value()"
    :image="$ogImage?->url()"
>
    @include('sections.course-hero')
    @include('sections.course-goal')
    @include('sections.course-syllabus')
    @include('sections.course-deliverables')
    @include('sections.course-cta')
</x-layout>
