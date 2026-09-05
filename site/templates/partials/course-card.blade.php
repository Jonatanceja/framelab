@php
    /**
     * Tarjeta de curso compartida entre el home y la página de cursos.
     *
     * @var string      $cardTitle
     * @var string|null $cardTagline
     * @var string|null $cardDuration
     * @var string|null $cardSchedule
     * @var string|null $cardMentor
     * @var string|null $cardMentorRole
     * @var \Kirby\Cms\File|null $cardImage
     * @var string|null $cardLink
     * @var int         $cardIndex
     */
    $cardIndex ??= 0;
    $cardLink ??= null;
    $cardImage ??= null;
    $tag = $cardLink ? 'a' : 'article';
@endphp

<{{ $tag }}
    @if ($cardLink) href="{{ $cardLink }}" @endif
    class="card group flex flex-col"
    data-reveal
    style="--reveal-delay: {{ 100 * $cardIndex }}ms"
>
    <div class="bg-surface-2 relative aspect-[16/10] overflow-hidden">
        @include('partials.media', [
            'image' => $cardImage,
            'video' => null,
            'alt' => $cardTitle,
            'class' => 'ease-soft size-full object-cover transition-transform duration-[900ms] group-hover:scale-105',
            'sizes' => '(min-width: 1024px) 24rem, (min-width: 768px) 50vw, 100vw',
            'srcset' => 'card',
            'width' => 900,
            'placeholder' => 'Imagen del curso',
            'placeholderClass' => 'art-placeholder text-fg-subtle flex size-full items-center justify-center text-xs',
        ])
        <div class="from-surface absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t to-transparent"></div>
    </div>

    <div class="flex flex-1 flex-col p-6">
        <h3 class="text-fg text-lg leading-snug font-bold">{{ $cardTitle }}</h3>

        @if ($cardTagline)
            <p class="text-brand-text mt-2 text-sm leading-relaxed">{{ $cardTagline }}</p>
        @endif

        <ul class="text-fg-subtle mt-5 space-y-2 text-[13px]">
            @if ($cardDuration)
                <li class="flex items-center gap-2">
                    <svg class="text-fg-faint size-3.5 shrink-0" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <circle cx="8" cy="8" r="6.25" stroke="currentColor" stroke-width="1.3" />
                        <path d="M8 4.5V8l2.5 1.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    {{ $cardDuration }}
                </li>
            @endif
            @if ($cardSchedule)
                <li class="flex items-center gap-2">
                    <svg class="text-fg-faint size-3.5 shrink-0" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <rect x="2" y="3.25" width="12" height="10.5" rx="2" stroke="currentColor" stroke-width="1.3" />
                        <path d="M2 6.5h12M5.5 1.75v2.5M10.5 1.75v2.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" />
                    </svg>
                    {{ $cardSchedule }}
                </li>
            @endif
        </ul>

        @if ($cardMentor)
            <div class="border-line mt-6 border-t pt-4">
                <p class="text-fg text-[13px] font-semibold">Mentor: {{ $cardMentor }}</p>
                <p class="text-fg-subtle mt-0.5 text-xs">{{ $cardMentorRole }}</p>
            </div>
        @endif

        @if ($cardLink)
            <span
                class="group-hover:text-brand-hover text-fg mt-5 inline-flex items-center gap-1.5 text-sm font-semibold transition"
            >
                Ver curso
                <svg class="size-3.5 transition-transform group-hover:translate-x-1" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M3 8h10m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </span>
        @endif
    </div>
</{{ $tag }}>
