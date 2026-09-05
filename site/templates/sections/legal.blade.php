@php
    $sections = $page->sections()->toStructure();
    $email = $page->contactEmail()->or(site()->email())->value();

    // Ancla legible por apartado, para poder enlazar a un punto concreto.
    $anchor = fn (string $heading, int $index) => 'apartado-'.($index + 1).'-'.\Kirby\Toolkit\Str::slug($heading);
@endphp
<section class="relative overflow-hidden pt-32 pb-24 lg:pt-40 lg:pb-32">
    <div
        class="bg-violet-brand/8 pointer-events-none absolute -top-32 -left-32 h-[26rem] w-[26rem] rounded-full blur-3xl"
    ></div>

    <div class="relative mx-auto max-w-5xl px-5 sm:px-8">
        <header class="max-w-2xl" data-reveal>
            @if ($page->subtitle()->isNotEmpty())
                <p class="eyebrow">
                    <span class="bg-pink-brand size-1.5 rounded-full"></span>
                    {{ $page->subtitle() }}
                </p>
            @endif

            <h1 class="mt-7 text-4xl font-extrabold sm:text-5xl">{{ $page->title() }}</h1>

            @if ($page->updatedAt()->isNotEmpty())
                <p class="text-fg-subtle mt-4 text-sm">
                    {{ $page->updatedLabel()->or('Última actualización') }}:
                    <time
                        datetime="{{ $page->updatedAt()->toDate('Y-m-d') }}"
                        >{{ $page->updatedAt()->toDate('d/m/Y') }}</time
                    >
                </p>
            @endif

            @if ($page->intro()->isNotEmpty())
                <p class="text-fg-muted mt-6 leading-relaxed">{{ $page->intro() }}</p>
            @endif
        </header>

        @if ($sections->isNotEmpty())
            <div class="mt-14 grid gap-12 lg:grid-cols-[16rem_1fr] lg:gap-16">
                <nav class="lg:sticky lg:top-28 lg:self-start" aria-label="Índice" data-reveal>
                    <p class="text-fg-subtle text-xs font-semibold tracking-[0.16em] uppercase">Contenido</p>

                    <ol class="mt-4 space-y-2.5">
                        @foreach ($sections as $section)
                            <li>
                                <a
                                    href="#{{ $anchor($section->heading()->value(), $loop->index) }}"
                                    class="text-fg-muted hover:text-brand-hover flex gap-2.5 text-sm leading-snug transition"
                                >
                                    <span class="text-fg-subtle tabular-nums">{{ $loop->iteration }}.</span>
                                    {{ $section->heading() }}
                                </a>
                            </li>
                        @endforeach
                    </ol>
                </nav>

                <div class="min-w-0 space-y-10">
                    @foreach ($sections as $section)
                        <article
                            id="{{ $anchor($section->heading()->value(), $loop->index) }}"
                            class="scroll-mt-28"
                            data-reveal
                        >
                            <h2 class="flex gap-3 text-xl font-bold sm:text-2xl">
                                <span class="text-brand-text tabular-nums">{{ $loop->iteration }}.</span>
                                {{ $section->heading() }}
                            </h2>

                            <div
                                class="prose prose-fl prose-a:text-brand-text prose-li:my-1 prose-p:leading-relaxed mt-4 max-w-none"
                            >
                                @kirbytext($section->text())
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($page->contactText()->isNotEmpty() || $email)
            <aside
                class="border-line bg-surface mt-16 rounded-2xl border p-7 lg:ml-[calc(16rem+4rem)] lg:p-8"
                data-reveal
            >
                <h2 class="text-base font-bold">¿Dudas sobre este documento?</h2>

                @if ($page->contactText()->isNotEmpty())
                    <p class="text-fg-muted mt-3 text-sm leading-relaxed">{{ $page->contactText() }}</p>
                @endif

                @if ($email)
                    <a
                        href="mailto:{{ $email }}"
                        class="group text-brand-text hover:text-brand-hover mt-5 inline-flex items-center gap-2 text-sm font-semibold transition"
                    >
                        {{ $email }}
                        <svg class="size-3.5 transition-transform group-hover:translate-x-0.5" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                            <path d="M3 8h10m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                @endif
            </aside>
        @endif
    </div>
</section>
