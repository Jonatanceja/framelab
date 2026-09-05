@php
    $photo = $page->photo()->toFile();
    $photoVideo = $page->photoVideo()->toFile();
    $skills = $page->skills()->toStructure();
    $projects = $page->projects()->toStructure();
@endphp
<section class="relative overflow-hidden pt-32 pb-24 lg:pt-40 lg:pb-32">
    <div
        class="bg-violet-brand/10 pointer-events-none absolute top-1/4 -left-40 h-[26rem] w-[26rem] rounded-full blur-3xl"
    ></div>
    <div class="bg-pink-brand/8 pointer-events-none absolute right-0 bottom-1/4 h-80 w-80 rounded-full blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl px-5 sm:px-8">
        <nav class="text-fg-subtle mb-10 flex items-center gap-2 text-xs" aria-label="Migas de pan">
            <a href="{{ $page->parent()->url() }}" class="hover:text-fg transition">{{ $page->parent()->title() }}</a>
            <span aria-hidden="true">/</span>
            <span class="text-fg-muted">{{ $page->title() }}</span>
        </nav>

        <div class="grid gap-12 lg:grid-cols-[minmax(0,_22rem)_1fr] lg:gap-14">
            <div class="relative" data-reveal>
                <div
                    class="from-violet-brand/25 via-pink-brand/15 absolute -inset-3 -z-10 rounded-[2rem] bg-gradient-to-br to-transparent blur-2xl"
                ></div>

                <div
                    class="bg-surface border-line shadow-shade overflow-hidden rounded-2xl border p-2 shadow-2xl lg:sticky lg:top-28"
                >
                    @include('partials.media', [
                        'image' => $photo,
                        'video' => $photoVideo,
                        'alt' => $page->title()->value(),
                        'class' => 'aspect-[4/5] w-full rounded-xl object-cover',
                        'sizes' => '(min-width: 1024px) 22rem, 100vw',
                        'srcset' => 'card',
                        'width' => 900,
                        'priority' => true,
                        'placeholder' => 'Sube el retrato en el panel → Perfil',
                        'placeholderClass' => 'art-placeholder text-fg-subtle flex aspect-[4/5] w-full items-center justify-center rounded-xl text-sm',
                    ])
                </div>
            </div>

            <div>
                <h1 class="text-3xl font-extrabold sm:text-4xl lg:text-[2.75rem]" data-reveal>{{ $page->title() }}</h1>

                @if ($page->role()->isNotEmpty())
                    <p
                        class="text-brand-text mt-3 text-sm font-semibold tracking-[0.14em] uppercase"
                        data-reveal
                        style="--reveal-delay: 60ms"
                    >
                        {{ $page->role() }}
                    </p>
                @endif

                @if ($page->bio()->isNotEmpty())
                    <div
                        class="bg-surface border-line relative mt-9 overflow-hidden rounded-2xl border p-7 lg:p-9"
                        data-reveal
                        style="--reveal-delay: 120ms"
                    >
                        <span
                            class="from-pink-brand to-violet-bright absolute inset-x-0 top-0 h-0.5 bg-gradient-to-r"
                        ></span>

                        <div
                            class="prose prose-fl prose-p:leading-relaxed prose-strong:text-fg text-fg-muted max-w-none"
                        >
                            @kirbytext($page->bio())
                        </div>
                    </div>
                @endif

                @if ($skills->isNotEmpty())
                    <ul class="mt-8 flex flex-wrap gap-3" data-reveal style="--reveal-delay: 180ms">
                        @foreach ($skills as $skill)
                            <li
                                class="border-violet-brand/35 bg-violet-brand/12 text-violet-text rounded-full border px-5 py-2 text-sm font-semibold"
                            >
                                {{ $skill->text() }}
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if ($projects->isNotEmpty())
                    <div class="mt-12" data-reveal style="--reveal-delay: 240ms">
                        <h2 class="text-fg text-base font-bold">
                            {{ $page->projectsTitle()->or('Proyectos destacados') }}
                        </h2>

                        <ul class="mt-5 flex flex-wrap gap-x-7 gap-y-3">
                            @foreach ($projects as $project)
                                <li>
                                    @php
                                        $link = $project->link()->isNotEmpty() ? $project->link()->value() : null;
                                        $tag = $link ? 'a' : 'span';
                                    @endphp

                                    <{{ $tag }}
                                        @if ($link) href="{{ $link }}" target="_blank" rel="noopener" @endif
                                        class="group flex items-center gap-2 text-sm text-fg-muted {{ $link ? 'transition hover:text-fg' : '' }}"
                                        @if ($project->detail()->isNotEmpty()) title="{{ $project->detail() }}" @endif
                                    >
                                        <svg class="text-brand-text size-3.5 shrink-0" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                            <rect x="1.75" y="3.25" width="12.5" height="9.5" rx="1.5" stroke="currentColor" stroke-width="1.3" />
                                            <path d="M1.75 6h12.5M5 3.25v2.5m6-2.5v2.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" />
                                        </svg>
                                        {{ $project->title() }}
                                        @if ($link)
                                            <span class="sr-only">(abre en una pestaña nueva)</span>
                                        @endif
                                    </{{ $tag }}>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
