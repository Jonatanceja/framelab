@php
    $image = $page->aboutImage()->toFile();
    $video = $page->aboutVideo()->toFile();
    $list = $page->aboutList()->toStructure();
@endphp
<section id="nosotros" class="relative py-24 lg:py-32">
    <div class="bg-violet-brand/8 pointer-events-none absolute top-1/4 -left-40 h-96 w-96 rounded-full blur-3xl"></div>

    <div class="relative mx-auto grid max-w-7xl items-center gap-14 px-5 sm:px-8 lg:grid-cols-2 lg:gap-20">
        <div data-reveal>
            <h2 class="text-4xl font-extrabold sm:text-5xl">
                {{ $page->aboutTitle() }} <span class="text-gradient">{{ $page->aboutTitleAccent() }}</span>
            </h2>

            <p class="text-fg-muted mt-6 max-w-lg leading-relaxed">{{ $page->aboutText() }}</p>

            @if ($list->isNotEmpty())
                <p class="text-fg mt-10 text-sm font-semibold tracking-wide">{{ $page->aboutListTitle() }}</p>

                <ul class="mt-5 space-y-3.5">
                    @foreach ($list as $item)
                        <li
                            class="text-fg-muted flex items-start gap-3 text-sm"
                            data-reveal
                            style="--reveal-delay: {{ 80 * $loop->index }}ms"
                        >
                            <span
                                class="border-pink-brand/40 bg-pink-brand/10 text-brand-hover mt-0.5 inline-flex size-5 shrink-0 items-center justify-center rounded-full border"
                            >
                                <svg class="size-3" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                    <path d="m3.5 8.5 3 3 6-7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            {{ $item->text() }}
                        </li>
                    @endforeach
                </ul>
            @endif

            @if ($about = page('nosotros'))
                <a
                    href="{{ $about->url() }}"
                    class="group hover:text-brand-hover text-fg mt-9 inline-flex items-center gap-2 text-sm font-semibold transition"
                >
                    Conoce Frame Lab
                    <svg class="size-3.5 transition-transform group-hover:translate-x-1" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M3 8h10m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            @endif
        </div>

        <div class="relative" data-reveal style="--reveal-delay: 120ms">
            <div
                class="from-pink-brand/25 via-violet-brand/20 absolute -inset-3 -z-10 rounded-[2.25rem] bg-gradient-to-tr to-transparent blur-2xl"
            ></div>

            <div class="bg-surface border-line shadow-shade overflow-hidden rounded-3xl border p-2 shadow-2xl">
                @include('partials.media', [
                        'image' => $image,
                        'video' => $video,
                        'alt' => 'Frame Lab',
                        'class' => 'aspect-[16/10] w-full rounded-2xl object-cover',
                        'sizes' => '(min-width: 1024px) 42rem, 100vw',
                        'width' => 1440,
                        'placeholder' => 'Sube una imagen o video en el panel → Nosotros',
                        'placeholderClass' => 'art-placeholder text-fg-subtle flex aspect-[16/10] w-full items-center justify-center rounded-2xl text-sm',
                    ])
            </div>
        </div>
    </div>
</section>
