@php
    $image = $page->heroImage()->toFile();
    $video = $page->heroVideo()->toFile();
    $stats = $page->heroStats()->toStructure();
@endphp
<section id="inicio" class="relative isolate flex min-h-[92vh] items-end overflow-hidden pt-28 pb-14 sm:pb-20 lg:pb-32">
    <div class="absolute inset-0 -z-10">
        @include('partials.media', [
            'image' => $image,
            'video' => $video,
            'class' => 'size-full object-cover object-center',
            'sizes' => '100vw',
            'width' => 2000,
            'priority' => true,
            'placeholder' => '',
            'placeholderClass' => 'art-backdrop size-full',
        ])

        <div class="from-bg via-bg/85 to-bg/20 absolute inset-0 bg-gradient-to-r"></div>
        <div class="from-bg to-bg/70 absolute inset-0 bg-gradient-to-t via-transparent"></div>
    </div>

    <div class="mx-auto w-full max-w-7xl px-5 sm:px-8">
        <div class="max-w-2xl">
            @if ($page->heroBadge()->isNotEmpty())
                <p class="eyebrow" data-reveal>
                    <svg class="text-brand-hover size-3" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path d="M9 1 3 9h4l-1 6 6-8H8l1-6Z" />
                    </svg>
                    {{ $page->heroBadge() }}
                </p>
            @endif

            <h1
                class="mt-6 text-5xl leading-[0.95] font-extrabold sm:text-6xl lg:text-7xl"
                data-reveal
                style="--reveal-delay: 80ms"
            >
                <span class="text-gradient block">{{ $page->heroTitleAccent() }}</span>
                <span class="text-fg block">{{ $page->heroTitleRest() }}</span>
            </h1>

            <p
                class="text-fg-muted mt-6 max-w-lg text-base leading-relaxed sm:text-lg"
                data-reveal
                style="--reveal-delay: 160ms"
            >
                {{ $page->heroText() }}
            </p>

            <div class="mt-9 flex flex-wrap items-center gap-3" data-reveal style="--reveal-delay: 240ms">
                @if ($page->heroPrimaryLabel()->isNotEmpty())
                    <a
                        href="{{ $page->heroPrimaryLink()->or('#cursos') }}"
                        class="btn btn-primary"
                        >{{ $page->heroPrimaryLabel() }}</a
                    >
                @endif
                @if ($page->heroSecondaryLabel()->isNotEmpty())
                    <a
                        href="{{ $page->heroSecondaryLink()->or('#cursos') }}"
                        class="btn btn-ghost"
                        >{{ $page->heroSecondaryLabel() }}</a
                    >
                @endif
            </div>

            @if ($stats->isNotEmpty())
                <dl
                    class="border-line mt-12 grid max-w-xl grid-cols-2 gap-x-6 gap-y-7 border-t pt-8 sm:grid-cols-4"
                    data-reveal
                    style="--reveal-delay: 320ms"
                >
                    @foreach ($stats as $stat)
                        <div>
                            <dt class="font-display text-fg text-2xl font-bold sm:text-[28px]">{{ $stat->value() }}</dt>
                            <dd class="text-fg-subtle mt-1 text-xs leading-snug">{{ $stat->label() }}</dd>
                        </div>
                    @endforeach
                </dl>
            @endif
        </div>
    </div>

    {{-- Mismo contenedor que el contenido para que el botón quede a su misma
         línea izquierda en cualquier ancho de pantalla. --}}
    <div class="pointer-events-none absolute inset-x-0 bottom-8 hidden lg:block">
        <div class="mx-auto max-w-7xl px-5 sm:px-8">
            <a
                href="#nosotros"
                class="hover:border-pink-brand/60 border-line-strong text-fg-muted hover:text-fg pointer-events-auto inline-flex size-12 items-center justify-center rounded-full border transition"
                aria-label="Bajar a la siguiente sección"
            >
                <svg class="size-4 animate-bounce" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M8 3v10m0 0 4-4m-4 4-4-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        </div>
    </div>
</section>
