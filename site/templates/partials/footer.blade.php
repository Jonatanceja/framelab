@php
    $columns = site()->footerColumns()->toStructure();
    $legal = site()->footerLegal()->toStructure();
    $social = site()->social()->toStructure();
@endphp
<footer id="contacto" class="bg-bg-soft border-line relative overflow-hidden border-t">
    <div class="bg-violet-brand/12 pointer-events-none absolute -top-40 -left-24 h-80 w-80 rounded-full blur-3xl"></div>
    <div
        class="bg-pink-brand/10 pointer-events-none absolute -right-24 -bottom-32 h-80 w-80 rounded-full blur-3xl"
    ></div>

    <div class="relative mx-auto max-w-7xl px-5 py-16 sm:px-8 lg:py-20">
        <div class="grid gap-12 lg:grid-cols-[1.4fr_1fr_1fr_1fr]">
            <div>
                <img
                    src="{{ url('/images/brand/frame-lab-logo-ink.svg') }}"
                    alt="Frame Lab"
                    class="logo-light h-4 w-auto"
                />
                <img src="{{ url('/images/brand/frame-lab-logo.svg') }}" alt="" class="logo-dark h-4 w-auto" />

                <p class="text-fg-subtle mt-6 max-w-xs text-sm leading-relaxed">
                    {{ site()->footerCopyright() }}<br />
                    {{ site()->footerTagline() }}
                </p>

                @if (site()->email()->isNotEmpty())
                    <a
                        href="mailto:{{ site()->email() }}"
                        class="text-brand-text hover:text-brand-hover mt-5 inline-block text-sm font-medium transition"
                    >
                        {{ site()->email() }}
                    </a>
                @endif

                @if ($social->isNotEmpty())
                    <ul class="mt-6 flex items-center gap-3">
                        @foreach ($social as $item)
                            <li>
                                <a
                                    href="{{ $item->link() }}"
                                    target="_blank"
                                    rel="noopener"
                                    class="hover:border-pink-brand/60 border-line text-fg-muted hover:text-fg inline-flex size-9 items-center justify-center rounded-full border text-xs font-semibold uppercase transition"
                                    aria-label="{{ site()->title() }} en {{ ucfirst($item->platform()->value()) }} (abre en una pestaña nueva)"
                                >
                                    @include('partials.social-icon', ['platform' => $item->platform()->value()])
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            @foreach ($columns as $column)
                <div>
                    <h2 class="text-fg text-sm font-semibold tracking-wide">{{ $column->headline() }}</h2>
                    <a
                        href="mailto:{{ $column->email() }}"
                        class="text-fg-muted hover:text-fg mt-4 block text-sm transition"
                    >
                        {{ $column->email() }}
                    </a>
                    <button
                        type="button"
                        data-copy="{{ $column->email() }}"
                        class="hover:text-brand-hover text-fg-subtle mt-3 inline-flex items-center gap-1.5 text-xs font-medium transition"
                    >
                        <svg class="size-3.5" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                            <path
                                d="M6.5 2.5h6a1 1 0 0 1 1 1v6m-3-3.5v6a1 1 0 0 1-1 1h-6a1 1 0 0 1-1-1v-6a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1Z"
                                stroke="currentColor"
                                stroke-width="1.3"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                        <span data-copy-label>Copiar vínculo</span>
                        <span class="sr-only" data-copy-status role="status" aria-live="polite"></span>
                    </button>
                </div>
            @endforeach

            @if ($legal->isNotEmpty())
                <div>
                    <h2 class="text-fg text-sm font-semibold tracking-wide">Legal</h2>
                    <ul class="mt-4 space-y-2.5">
                        @foreach ($legal as $item)
                            <li>
                                <a
                                    href="{{ $item->link() }}"
                                    class="text-fg-muted hover:text-fg text-sm transition"
                                    >{{ $item->label() }}</a
                                >
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    {{-- Barra inferior: crédito del estudio --}}
    @if (site()->creditName()->isNotEmpty())
        <div class="border-line relative border-t">
            <div class="mx-auto max-w-3xl px-5 py-6 text-center sm:px-8">
                <p class="text-fg-subtle text-xs">
                    {{ site()->creditLabel() }}
                    <a
                        href="{{ site()->creditLink() }}"
                        target="_blank"
                        rel="noopener"
                        class="text-fg-muted hover:text-brand-hover group inline-flex items-center gap-1.5 font-semibold transition"
                    >
                        {{ site()->creditName() }}
                        <span class="sr-only">(abre en una pestaña nueva)</span>
                        <img
                            src="{{ url('/images/brand/webxpress.svg') }}"
                            alt=""
                            width="14"
                            height="15"
                            loading="lazy"
                            class="ease-soft h-3.5 w-auto transition-transform duration-300 group-hover:-translate-y-0.5"
                        />
                    </a>
                </p>
            </div>
        </div>
    @endif
</footer>
