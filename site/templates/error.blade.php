@php
    /**
     * Página que Kirby sirve ante cualquier dirección inexistente (404).
     *
     * @var Kirby\Cms\App $kirby
     * @var Kirby\Cms\Page $page
     * @var Kirby\Cms\Site $site
     */
    $links = $page->links()->toPages();
    $contact = $site->find('contacto');
@endphp

<x-layout :description="$page->metaDescription()->value()">
    <section class="relative isolate flex min-h-[80vh] items-center overflow-hidden pt-32 pb-24">
        <div class="art-backdrop absolute inset-0 -z-10"></div>
        <div class="from-bg via-bg/80 to-bg absolute inset-0 -z-10 bg-gradient-to-b"></div>

        <div class="mx-auto w-full max-w-2xl px-5 text-center sm:px-8">
            <p
                class="text-gradient font-display text-8xl leading-none font-extrabold sm:text-9xl"
                aria-hidden="true"
                data-reveal
            >
                {{ $page->errorCode()->or('404') }}
            </p>

            <h1 class="text-fg mt-6 text-4xl font-extrabold sm:text-5xl" data-reveal style="--reveal-delay: 80ms">
                {{ $page->heading()->or('Esta página se salió de cuadro') }}
            </h1>

            <p class="text-fg-muted mx-auto mt-5 max-w-lg leading-relaxed" data-reveal style="--reveal-delay: 160ms">
                {{ $page->text()->or('La dirección que buscas no existe o cambió de lugar. Vuelve al inicio y sigue desde ahí.') }}
            </p>

            <div class="mt-9 flex flex-wrap justify-center gap-3" data-reveal style="--reveal-delay: 240ms">
                <a href="{{ $site->url() }}" class="btn btn-primary">
                    {{ $page->buttonLabel()->or('Volver al inicio') }}
                    <svg class="size-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path
                            d="M3 8h10m0 0-4-4m4 4-4 4"
                            stroke="currentColor"
                            stroke-width="1.75"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </a>

                @if ($contact && $page->contactLabel()->isNotEmpty())
                    <a href="{{ $contact->url() }}" class="btn btn-ghost">{{ $page->contactLabel() }}</a>
                @endif
            </div>

            @if ($links->isNotEmpty())
                <div class="mt-14" data-reveal style="--reveal-delay: 320ms">
                    <p class="text-fg-subtle text-xs tracking-[0.16em] uppercase">
                        {{ $page->linksTitle()->or('O sigue por aquí') }}
                    </p>

                    <ul class="mt-5 flex flex-wrap justify-center gap-3">
                        @foreach ($links as $link)
                            <li>
                                <a
                                    href="{{ $link->url() }}"
                                    class="border-line bg-fill text-fg hover:border-pink-brand hover:text-brand-hover ease-soft inline-flex rounded-full border px-5 py-2 text-sm font-medium backdrop-blur transition duration-300"
                                >
                                    {{ $link->title() }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </section>
</x-layout>
