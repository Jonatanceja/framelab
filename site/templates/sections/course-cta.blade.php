@php
    $image = $page->ctaImage()->toFile();
    $video = $page->ctaVideo()->toFile();
@endphp
<section id="inscripcion" class="relative isolate overflow-hidden">
    <div class="absolute inset-0 -z-10">
        @include('partials.media', [
            'image' => $image,
            'video' => $video,
            'class' => 'size-full object-cover object-center',
            'sizes' => '100vw',
            'width' => 2000,
            'placeholder' => '',
            'placeholderClass' => 'art-backdrop size-full',
        ])
        @if ($image || $video)
            <div class="bg-bg/55 absolute inset-0"></div>
        @endif

        <div class="from-bg to-bg absolute inset-0 bg-gradient-to-b via-transparent"></div>
    </div>

    <div class="mx-auto max-w-3xl px-5 py-24 text-center sm:px-8 lg:py-32">
        <h2 class="text-4xl font-extrabold sm:text-5xl" data-reveal>{{ $page->ctaTitle() }}</h2>

        <p class="text-fg-muted mx-auto mt-6 max-w-xl leading-relaxed" data-reveal style="--reveal-delay: 80ms">
            {{ $page->ctaText() }}
        </p>

        @if ($page->ctaButton()->isNotEmpty())
            <div class="mt-10" data-reveal style="--reveal-delay: 160ms">
                <a href="{{ $page->ctaLink()->or('#temario') }}" class="btn btn-primary px-8 py-3.5 text-base">
                    {{ $page->ctaButton() }}
                    <svg class="size-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M3 8h10m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
        @endif
    </div>
</section>
