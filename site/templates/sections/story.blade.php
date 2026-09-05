@php
    $image = $page->storyImage()->toFile();
    $video = $page->storyVideo()->toFile();
    $stats = $page->storyStats()->toStructure();
@endphp
<section id="historia" class="relative overflow-hidden pt-36 pb-20 lg:pt-44 lg:pb-28">
    <div
        class="bg-violet-brand/10 pointer-events-none absolute -top-32 -left-32 h-[28rem] w-[28rem] rounded-full blur-3xl"
    ></div>
    <div class="bg-pink-brand/8 pointer-events-none absolute top-1/3 -right-40 h-96 w-96 rounded-full blur-3xl"></div>

    <div class="relative mx-auto grid max-w-7xl items-center gap-14 px-5 sm:px-8 lg:grid-cols-2 lg:gap-16">
        <div data-reveal>
            @if ($page->storyBadge()->isNotEmpty())
                <p class="eyebrow">
                    <span class="bg-pink-bright size-1.5 rounded-full"></span>
                    {{ $page->storyBadge() }}
                </p>
            @endif

            <h1 class="mt-7 text-4xl leading-[1.05] font-extrabold sm:text-5xl lg:text-6xl">
                <span class="text-fg block">{{ $page->storyTitle() }}</span>
                <span class="text-gradient block">{{ $page->storyTitleAccent() }}</span>
            </h1>

            <p class="text-fg-muted mt-7 max-w-lg leading-relaxed">{{ $page->storyText() }}</p>

            @if ($stats->isNotEmpty())
                <dl class="mt-10 grid max-w-lg gap-4 sm:grid-cols-2">
                    @foreach ($stats as $stat)
                        <div
                            class="lift bg-surface border-line hover:border-pink-brand/40 rounded-2xl border px-6 py-5 text-center"
                            data-reveal
                            style="--reveal-delay: {{ 100 * $loop->index }}ms"
                        >
                            <dt class="font-display text-brand-hover text-2xl font-bold">{{ $stat->value() }}</dt>
                            <dd class="text-fg-subtle mt-1 text-xs tracking-[0.14em] uppercase">
                                {{ $stat->label() }}
                            </dd>
                        </div>
                    @endforeach
                </dl>
            @endif
        </div>

        <div class="relative" data-reveal style="--reveal-delay: 120ms">
            <div
                class="from-violet-brand/25 via-pink-brand/15 absolute -inset-4 -z-10 rounded-[2.5rem] bg-gradient-to-br to-transparent blur-2xl"
            ></div>

            <div class="bg-surface border-line shadow-shade overflow-hidden rounded-3xl border p-2 shadow-2xl">
                @include('partials.media', [
                        'image' => $image,
                        'video' => $video,
                        'alt' => 'Frame Lab',
                        'class' => 'aspect-[4/3] w-full rounded-2xl object-cover',
                        'sizes' => '(min-width: 1024px) 40rem, 100vw',
                        'width' => 1440,
                        'placeholder' => 'Sube una imagen o video en el panel → Historia',
                        'placeholderClass' => 'art-placeholder text-fg-subtle flex aspect-[4/3] w-full items-center justify-center rounded-2xl text-sm',
                    ])
            </div>
        </div>
    </div>
</section>
