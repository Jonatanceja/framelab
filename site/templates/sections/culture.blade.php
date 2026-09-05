@php
    $image = $page->cultureImage()->toFile();
    $video = $page->cultureVideo()->toFile();
    $values = $page->cultureList()->toStructure();
@endphp
<section id="cultura" class="relative py-24 lg:py-32">
    <div class="bg-pink-brand/8 pointer-events-none absolute bottom-0 -left-40 h-96 w-96 rounded-full blur-3xl"></div>

    <div class="relative mx-auto grid max-w-7xl items-start gap-x-14 gap-y-10 px-5 sm:px-8 lg:grid-cols-2 lg:gap-x-16">
        <h2 class="text-4xl font-extrabold sm:text-5xl lg:col-start-1 lg:row-start-1" data-reveal>
            {{ $page->cultureTitle() }} <span class="text-gradient">{{ $page->cultureTitleAccent() }}</span>
        </h2>

        <div class="lg:col-start-1 lg:row-start-2">
            @if ($values->isNotEmpty())
                <div class="space-y-4">
                    @foreach ($values as $value)
                        <article
                            class="lift bg-surface border-line flex gap-4 rounded-2xl border p-6"
                            data-reveal
                            style="--reveal-delay: {{ 100 * $loop->index }}ms"
                        >
                            <span
                                class="border-pink-brand/30 bg-pink-brand/10 text-brand-hover inline-flex size-10 shrink-0 items-center justify-center rounded-xl border"
                            >
                                @include('partials.culture-icon', ['icon' => $value->icon()->value()])
                            </span>

                            <div>
                                <h3 class="text-fg text-base font-bold">{{ $value->title() }}</h3>
                                <p class="text-fg-muted mt-2 text-sm leading-relaxed">{{ $value->text() }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="relative lg:col-start-2 lg:row-start-2" data-reveal style="--reveal-delay: 120ms">
            <div
                class="from-pink-brand/25 via-violet-brand/20 absolute -inset-4 -z-10 rounded-[2.5rem] bg-gradient-to-tr to-transparent blur-2xl"
            ></div>

            <div class="bg-surface border-line shadow-shade overflow-hidden rounded-3xl border p-2 shadow-2xl">
                @include('partials.media', [
                        'image' => $image,
                        'video' => $video,
                        'alt' => 'Cultura Frame Lab',
                        'class' => 'aspect-[4/3] w-full rounded-2xl object-cover',
                        'sizes' => '(min-width: 1024px) 40rem, 100vw',
                        'width' => 1440,
                        'placeholder' => 'Sube una imagen o video en el panel → Cultura',
                        'placeholderClass' => 'art-placeholder text-fg-subtle flex aspect-[4/3] w-full items-center justify-center rounded-2xl text-sm',
                    ])
            </div>
        </div>
    </div>
</section>
