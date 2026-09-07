@php
    /**
     * Tarjeta de mentor. Los datos vienen de la ficha (página hija de Nosotros)
     * y el tipo de tarjeta se elige en su pestaña Perfil.
     *
     * @var \Kirby\Cms\Page $mentor
     */
    $image = $mentor->photo()->toFile();
    $video = $mentor->photoVideo()->toFile();
    $card = $mentor->card()->or('perfil')->value();
    // Cuando es la única tarjeta la retícula ya la centra: no debe abarcar columnas.
    $single = $single ?? false;

    $words = array_values(
        array_filter(preg_split('/\s+/u', trim($mentor->title()->value())), fn ($word) => preg_match('/^\p{L}/u', $word) === 1)
    );

    $initials = '';

    foreach (array_slice($words, 0, 2) as $word) {
        $initials .= mb_strtoupper(mb_substr($word, 0, 1));
    }
@endphp

<a
    href="{{ $mentor->url() }}"
    class="card group flex flex-col {{ $card === 'destacado' ? ($single ? 'min-h-[26rem] lg:min-h-[34rem]' : 'lg:col-span-2 lg:row-span-2 min-h-[26rem] lg:min-h-[34rem]') : 'min-h-[15rem]' }}"
    data-reveal
    style="--reveal-delay: {{ 100 * $index }}ms"
>
    @if ($card === 'perfil')
        <div class="flex flex-1 flex-col p-7">
            <div class="flex items-start justify-between gap-4">
                @if ($image)
                    <img
                        src="{{ $image->crop(160, 160)->url() }}"
                        alt="{{ $mentor->title() }}"
                        loading="lazy"
                        class="border-line-strong size-14 rounded-full border object-cover"
                    />
                @else
                    <span
                        class="border-line font-display text-fg from-pink-brand/30 to-violet-brand/30 inline-flex size-14 items-center justify-center rounded-full border bg-gradient-to-br text-lg font-bold"
                    >
                        {{ $initials }}
                    </span>
                @endif

                <span
                    class="border-line text-fg-subtle group-hover:border-pink-brand group-hover:text-brand-hover inline-flex size-9 shrink-0 items-center justify-center rounded-full border transition"
                >
                    <svg class="size-3.5" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M3 8h10m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </div>

            <h3 class="text-fg mt-5 text-base font-bold">{{ $mentor->title() }}</h3>
            <p class="text-fg-subtle mt-1 text-xs tracking-[0.14em] uppercase">{{ $mentor->role() }}</p>
            <p class="text-fg-muted mt-4 text-sm leading-relaxed">{{ $mentor->tagline() }}</p>
        </div>
    @else
        <div class="relative flex flex-1 flex-col justify-end overflow-hidden">
            @include('partials.media', [
                'image' => $image,
                'video' => $video,
                'alt' => $mentor->title()->value(),
                'class' => 'ease-soft absolute inset-0 size-full object-cover transition-transform duration-[900ms] group-hover:scale-105',
                'sizes' => $card === 'destacado' ? '(min-width: 1024px) 48rem, 100vw' : '(min-width: 1024px) 24rem, 100vw',
                'srcset' => $card === 'destacado' ? 'default' : 'card',
                'width' => $card === 'destacado' ? 1440 : 900,
                'placeholder' => '',
                'placeholderClass' => 'art-placeholder absolute inset-0',
            ])

            <div class="from-bg via-bg/55 absolute inset-0 bg-gradient-to-t to-transparent"></div>

            <div class="relative p-6 {{ $card === 'destacado' ? 'lg:p-8' : '' }}">
                @if ($card === 'destacado' && $mentor->badge()->isNotEmpty())
                    <span
                        class="text-brand-text border-pink-brand/40 bg-pink-brand/15 inline-flex rounded-full border px-3 py-1 text-[11px] font-semibold tracking-[0.16em] uppercase backdrop-blur"
                    >
                        {{ $mentor->badge() }}
                    </span>
                @endif

                <div class="mt-4 flex items-end justify-between gap-6">
                    <div>
                        <h3 class="text-fg text-lg font-bold {{ $card === 'destacado' ? 'lg:text-xl' : '' }}">
                            {{ $mentor->title() }}
                        </h3>
                        <p class="text-brand-text mt-1 text-xs tracking-[0.14em] uppercase">{{ $mentor->role() }}</p>

                        @if ($card === 'destacado' && $mentor->tagline()->isNotEmpty())
                            <p class="text-fg-muted mt-3 max-w-md text-sm leading-relaxed">{{ $mentor->tagline() }}</p>
                        @endif
                    </div>

                    @if ($card === 'destacado')
                        <span
                            class="border-line-strong text-fg group-hover:border-pink-brand group-hover:bg-pink-brand hidden size-11 shrink-0 items-center justify-center rounded-full border transition sm:inline-flex"
                        >
                            <svg class="size-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                <path d="M3 8h10m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @endif
</a>
