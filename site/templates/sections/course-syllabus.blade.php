@php
    $sessions = $page->sessions()->toStructure();
@endphp
@if ($sessions->isNotEmpty())
    <section id="temario" class="py-24 lg:py-32">
        <div class="mx-auto max-w-7xl px-5 sm:px-8">
            <div class="mx-auto max-w-2xl text-center" data-reveal>
                <h2 class="text-3xl font-extrabold sm:text-4xl">{{ $page->syllabusTitle() }}</h2>
                <p class="text-fg-muted mx-auto mt-5 leading-relaxed">{{ $page->syllabusText() }}</p>
            </div>

            <div class="mt-14 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($sessions as $session)
                    @php
                        $topics = $session->topics()->toStructure();
                        $highlight = $session->highlight()->toBool();
                    @endphp

                    <article
                        class="card flex flex-col p-6 {{ $highlight ? 'border-line-strong ring-1 ring-pink-brand/30' : '' }}"
                        data-reveal
                        style="--reveal-delay: {{ 100 * $loop->index }}ms"
                    >
                        @if ($highlight)
                            <span
                                class="from-pink-brand to-violet-bright absolute inset-x-0 top-0 h-0.5 bg-gradient-to-r"
                            ></span>
                        @endif

                        <span
                            class="border-violet-brand/30 bg-violet-brand/10 text-violet-text inline-flex size-10 items-center justify-center rounded-xl border"
                        >
                            @include('partials.session-icon', ['icon' => $session->icon()->value()])
                        </span>

                        <h3 class="text-fg mt-6 text-base font-bold">{{ $session->title() }}</h3>
                        <p class="text-brand-text mt-1.5 text-sm font-medium">{{ $session->duration() }}</p>

                        @if ($topics->isNotEmpty())
                            <ul class="mt-5 space-y-2.5">
                                @foreach ($topics as $topic)
                                    <li class="text-fg-muted flex items-start gap-2.5 text-sm leading-snug">
                                        <svg class="text-brand-text/70 mt-0.5 size-3.5 shrink-0" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                            <circle cx="8" cy="8" r="6.25" stroke="currentColor" stroke-width="1.3" />
                                            <path d="m5.5 8.2 1.8 1.8 3.2-3.8" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        {{ $topic->text() }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        @if ($session->text()->isNotEmpty())
                            <p class="text-fg-muted mt-5 text-sm leading-relaxed">{{ $session->text() }}</p>
                        @endif
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif
