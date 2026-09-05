@php
    /**
     * @var Kirby\Cms\App $kirby
     * @var Kirby\Cms\Page $page
     * @var Kirby\Cms\Site $site
     */
@endphp

<x-layout>
    <section class="mx-auto max-w-3xl px-5 pt-40 pb-24 sm:px-8">
        <h1 class="text-4xl font-extrabold sm:text-5xl">{{ $page->title() }}</h1>

        <div class="prose prose-fl prose-headings:font-display prose-a:text-brand-text mt-8 max-w-none">
            @kirbytext($page->text())
        </div>
    </section>
</x-layout>
