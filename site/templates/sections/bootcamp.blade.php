@php
    $image = $page->bootcampImage()->toFile();
    $video = $page->bootcampVideo()->toFile();
@endphp
<section id="bootcamp" class="relative isolate overflow-hidden">
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
        <div class="bg-bg/60 absolute inset-0"></div>
        <div class="from-bg to-bg absolute inset-0 bg-gradient-to-b via-transparent"></div>
    </div>

    <div class="mx-auto max-w-3xl px-5 py-28 text-center sm:px-8 lg:py-36">
        @if ($page->bootcampEyebrow()->isNotEmpty())
            <p class="eyebrow border-pink-brand/30 bg-pink-brand/10 text-brand-text" data-reveal>
                {{ $page->bootcampEyebrow() }}
            </p>
        @endif

        <h2 class="mt-7 text-4xl font-extrabold sm:text-5xl lg:text-6xl" data-reveal style="--reveal-delay: 80ms">
            {{ $page->bootcampTitle() }}
        </h2>

        <p class="text-fg-muted mx-auto mt-6 max-w-xl leading-relaxed" data-reveal style="--reveal-delay: 160ms">
            {{ $page->bootcampText() }}
        </p>

        @if ($page->bootcampButtonLabel()->isNotEmpty())
            <div class="mt-10" data-reveal style="--reveal-delay: 240ms">
                <a
                    href="{{ $page->bootcampButtonLink()->or('#suscribete') }}"
                    class="btn btn-primary px-8 py-3.5 text-base"
                >
                    {{ $page->bootcampButtonLabel() }}
                </a>
            </div>
        @endif
    </div>
</section>
