@php
    $image = $page->cardImage()->toFile();
    $video = $page->cardVideo()->toFile();
    $syllabus = $page->syllabusFile()->toFile();
@endphp
<section class="relative overflow-hidden pt-32 pb-16 lg:pt-40 lg:pb-24">
    <div
        class="bg-violet-brand/10 pointer-events-none absolute -top-32 -left-32 h-[26rem] w-[26rem] rounded-full blur-3xl"
    ></div>

    <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-5 sm:px-8 lg:grid-cols-2 lg:gap-16">
        <div data-reveal>
            <nav class="text-fg-subtle mb-6 flex items-center gap-2 text-xs" aria-label="Migas de pan">
                <a
                    href="{{ $page->parent()->url() }}"
                    class="hover:text-fg transition"
                    >{{ $page->parent()->title() }}</a
                >
                <span aria-hidden="true">/</span>
                <span class="text-fg-muted">{{ $page->title() }}</span>
            </nav>

            @if ($page->badge()->isNotEmpty())
                <p
                    class="border-violet-brand/40 bg-violet-brand/15 text-fg-muted inline-flex items-center gap-2 rounded-full border px-4 py-1.5 text-xs font-semibold tracking-[0.16em] uppercase backdrop-blur"
                >
                    <svg class="text-violet-text size-3" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path d="M9 1 3 9h4l-1 6 6-8H8l1-6Z" />
                    </svg>
                    {{ $page->badge() }}
                </p>
            @endif

            <h1 class="mt-6 text-4xl leading-[1.05] font-extrabold sm:text-5xl">
                <span class="text-fg">{{ $page->heroTitle() }}</span>
                <span class="text-gradient">{{ $page->heroTitleAccent() }}</span>
            </h1>

            <p class="text-fg-muted mt-5">{{ $page->tagline() }}</p>

            <dl class="mt-7 space-y-1.5 text-sm">
                @if ($page->duration()->isNotEmpty())
                    <div class="flex flex-wrap gap-x-2">
                        <dt class="text-fg font-semibold">Duración:</dt>
                        <dd class="text-fg-muted">{{ $page->duration() }}</dd>
                    </div>
                @endif
                @if ($page->schedule()->isNotEmpty())
                    <div class="flex flex-wrap gap-x-2">
                        <dt class="text-fg font-semibold">Horario:</dt>
                        <dd class="text-fg-muted">{{ $page->schedule() }}</dd>
                    </div>
                @endif
            </dl>

            <div class="mt-9 flex flex-wrap items-center gap-3">
                @if ($page->primaryLabel()->isNotEmpty())
                    <a
                        href="{{ $page->primaryLink()->or('#inscripcion') }}"
                        class="btn btn-primary"
                        >{{ $page->primaryLabel() }}</a
                    >
                @endif

                @if ($syllabus && $page->secondaryLabel()->isNotEmpty())
                    <a href="{{ $syllabus->url() }}" download class="btn btn-ghost">
                        {{ $page->secondaryLabel() }}
                        <svg class="size-3.5" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                            <path d="M8 2.5v8m0 0 3-3m-3 3-3-3M2.5 13h11" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                @endif
            </div>
        </div>

        <div class="relative" data-reveal style="--reveal-delay: 120ms">
            <div
                class="from-pink-brand/25 via-violet-brand/20 absolute -inset-4 -z-10 rounded-[2.5rem] bg-gradient-to-br to-transparent blur-2xl"
            ></div>

            <div class="bg-surface border-line shadow-shade overflow-hidden rounded-3xl border p-2 shadow-2xl">
                @include('partials.media', [
                        'image' => $image,
                        'video' => $video,
                        'alt' => 'Portada del curso',
                        'class' => 'aspect-[16/10] w-full rounded-2xl object-cover',
                        'sizes' => '(min-width: 1024px) 40rem, 100vw',
                        'width' => 1440,
                        'placeholder' => 'Sube una imagen o video en el panel → Portada',
                        'placeholderClass' => 'art-placeholder text-fg-subtle flex aspect-[16/10] w-full items-center justify-center rounded-2xl text-sm',
                    ])
            </div>
        </div>
    </div>
</section>
