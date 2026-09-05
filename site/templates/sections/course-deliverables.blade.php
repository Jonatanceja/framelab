@php
    /** El instructor es una ficha de mentor: sus datos salen de ahí. */
    $deliverables = $page->deliverablesList()->toStructure();
    $instructor = $page->instructor()->toPage();
    $instructorImage = $instructor?->photo()->toFile();

    $projects = $instructor?->projects()->toStructure()->pluck('title', ',', true) ?? [];
@endphp
<section class="bg-bg-soft border-line border-t py-24 lg:py-32">
    <div class="mx-auto grid max-w-7xl items-center gap-14 px-5 sm:px-8 lg:grid-cols-2 lg:gap-16">
        <div data-reveal>
            <h2 class="text-3xl font-extrabold sm:text-4xl">{{ $page->deliverablesTitle() }}</h2>

            @if ($deliverables->isNotEmpty())
                <ul class="mt-8 space-y-3.5">
                    @foreach ($deliverables as $item)
                        <li class="text-fg-muted flex items-start gap-3">
                            <span
                                class="border-pink-brand/40 bg-pink-brand/10 text-brand-hover mt-0.5 inline-flex size-5 shrink-0 items-center justify-center rounded-full border"
                            >
                                <svg class="size-3" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                    <path d="m3.5 8.5 3 3 6-7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            {{ $item->text() }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        @if ($instructor)
            <aside
                class="border-line bg-surface rounded-2xl border p-7 lg:p-8"
                data-reveal
                style="--reveal-delay: 120ms"
            >
                <div class="flex flex-col gap-6 sm:flex-row">
                    <div class="shrink-0">
                        @if ($instructorImage)
                            <img
                                src="{{ $instructorImage->crop(320, 400)->url() }}"
                                alt="{{ $instructor->title() }}"
                                loading="lazy"
                                class="border-line h-32 w-28 rounded-xl border object-cover sm:h-36 sm:w-32"
                            />
                        @else
                            <div
                                class="border-line text-fg-subtle from-pink-brand/25 to-violet-brand/25 flex h-32 w-28 items-center justify-center rounded-xl border bg-gradient-to-br text-xs sm:h-36 sm:w-32"
                            >
                                Foto
                            </div>
                        @endif
                    </div>

                    <div>
                        <h3 class="text-fg text-base font-bold">{{ $instructor->title() }}</h3>

                        @if ($page->instructorBadge()->isNotEmpty())
                            <span
                                class="border-violet-brand/40 bg-violet-brand/15 text-fg-muted mt-2 inline-flex rounded-full border px-3 py-1 text-[11px] font-semibold tracking-[0.14em] uppercase"
                            >
                                {{ $page->instructorBadge() }}
                            </span>
                        @endif

                        <p class="text-fg-muted mt-4 text-sm leading-relaxed">{{ $instructor->tagline() }}</p>

                        @if ($projects)
                            <p class="text-fg-muted mt-4 text-sm leading-relaxed">
                                <span class="text-fg font-semibold"
                                    >{{ $page->instructorProjectsLabel()->or('Proyectos destacados') }}:</span
                                >
                                {{ implode(', ', $projects) }}
                            </p>
                        @endif

                        <a
                            href="{{ $instructor->url() }}"
                            class="group border-line-strong text-fg hover:border-pink-brand hover:text-brand-hover mt-6 inline-flex items-center gap-2 rounded-full border px-5 py-2 text-sm font-semibold transition"
                        >
                            {{ $page->instructorLinkLabel()->or('Ver ficha') }}
                            <svg class="size-3.5 transition-transform group-hover:translate-x-0.5" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                <path d="M3 8h10m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                </div>
            </aside>
        @endif
    </div>
</section>
