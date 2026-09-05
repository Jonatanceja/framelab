@php
    $image = $page->introImage()->toFile();
    $video = $page->introVideo()->toFile();
@endphp
<section class="relative isolate overflow-hidden pt-36 pb-16 lg:pt-44 lg:pb-20">
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

        {{-- Velo parejo para que se lea el texto, y desvanecido solo en la
             mitad inferior para entrar a la rejilla sin cortar la imagen. --}}
        @if ($image || $video)
            <div class="bg-bg/55 absolute inset-0"></div>
        @endif

        <div class="to-bg absolute inset-0 bg-gradient-to-b from-transparent via-transparent"></div>
    </div>

    <div class="mx-auto max-w-3xl px-5 text-center sm:px-8">
        @if ($page->introBadge()->isNotEmpty())
            <p class="eyebrow" data-reveal>
                <span class="bg-pink-bright size-1.5 rounded-full"></span>
                {{ $page->introBadge() }}
            </p>
        @endif

        <h1 class="mt-7 text-4xl font-extrabold sm:text-5xl lg:text-6xl" data-reveal style="--reveal-delay: 80ms">
            {{ $page->introTitle() }} <span class="text-gradient">{{ $page->introTitleAccent() }}</span>
        </h1>

        <p class="text-fg-muted mx-auto mt-6 max-w-xl leading-relaxed" data-reveal style="--reveal-delay: 160ms">
            {{ $page->introText() }}
        </p>
    </div>
</section>
