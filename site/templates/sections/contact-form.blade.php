@php
    $courses = page('cursos')?->children()->listed() ?? [];
    $emails = $page->emails()->toStructure();
@endphp
<section class="relative overflow-hidden pt-32 pb-20 lg:pt-40 lg:pb-24">
    <div
        class="bg-violet-brand/12 pointer-events-none absolute -top-24 right-0 h-[30rem] w-[30rem] rounded-full blur-3xl"
    ></div>
    <div
        class="bg-pink-brand/10 pointer-events-none absolute -bottom-32 -left-24 h-96 w-96 rounded-full blur-3xl"
    ></div>

    <div class="relative mx-auto max-w-7xl px-5 sm:px-8">
        <div class="bg-surface/70 border-line overflow-hidden rounded-3xl border p-8 backdrop-blur-sm sm:p-12 lg:p-16">
            <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
                <div data-reveal>
                    <h1 class="text-4xl leading-[1.05] font-extrabold sm:text-5xl lg:text-6xl">
                        {{ $page->introTitle() }} <span class="text-gradient">{{ $page->introTitleAccent() }}</span>
                    </h1>

                    <p class="text-fg-muted mt-6 max-w-md leading-relaxed">{{ $page->introText() }}</p>

                    <ul class="mt-10 space-y-6">
                        @if ($emails->isNotEmpty())
                            <li class="flex items-start gap-4">
                                <span
                                    class="border-pink-brand/35 bg-pink-brand/12 text-brand-hover inline-flex size-11 shrink-0 items-center justify-center rounded-full border"
                                >
                                    <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <rect x="3" y="5.5" width="18" height="13" rx="2.5" stroke="currentColor" stroke-width="1.5" />
                                        <path
                                            d="m4 7 8 5.5L20 7"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </svg>
                                </span>

                                <div class="space-y-3">
                                    @foreach ($emails as $item)
                                        <div>
                                            <p class="text-fg font-semibold">{{ $item->label() }}</p>
                                            <a
                                                href="mailto:{{ $item->address() }}"
                                                class="text-fg-muted hover:text-brand-hover text-sm transition"
                                            >
                                                {{ $item->address() }}
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </li>
                        @endif

                        @if ($page->phone()->isNotEmpty())
                            <li class="flex items-start gap-4">
                                <span
                                    class="border-pink-brand/35 bg-pink-brand/12 text-brand-hover inline-flex size-11 shrink-0 items-center justify-center rounded-full border"
                                >
                                    <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M6.5 3.5h3l1.5 4-2 1.5a12 12 0 0 0 6 6l1.5-2 4 1.5v3a2 2 0 0 1-2.2 2A16.5 16.5 0 0 1 4.5 5.7 2 2 0 0 1 6.5 3.5Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="text-fg font-semibold">Teléfono</p>
                                    <a
                                        href="tel:{{ $page->phone() }}"
                                        class="hover:text-brand-hover text-fg-muted text-sm transition"
                                        >{{ $page->phone() }}</a
                                    >
                                </div>
                            </li>
                        @endif

                        @if ($page->location()->isNotEmpty())
                            <li class="flex items-start gap-4">
                                <span
                                    class="border-violet-brand/40 bg-violet-brand/12 text-violet-text inline-flex size-11 shrink-0 items-center justify-center rounded-full border"
                                >
                                    <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M12 21s7-5.5 7-11a7 7 0 1 0-14 0c0 5.5 7 11 7 11Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                        <circle cx="12" cy="10" r="2.5" stroke="currentColor" stroke-width="1.5" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="text-fg font-semibold">{{ $page->locationLabel()->or('Ubicación') }}</p>
                                    <p class="text-fg-muted text-sm leading-relaxed">
                                        {!! nl2br(esc($page->location()->value())) !!}
                                    </p>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>

                <div class="relative" data-reveal style="--reveal-delay: 120ms">
                    <form
                        data-ajax-form
                        action="{{ url('mensaje') }}"
                        method="post"
                        data-success="{{ $page->successMessage()->or('¡Gracias! Te contactamos muy pronto.') }}"
                        class="bg-bg-soft border-line relative overflow-hidden rounded-2xl border p-7 sm:p-8"
                    >
                        <span
                            class="from-pink-brand to-violet-bright absolute inset-x-0 top-0 h-0.5 bg-gradient-to-r"
                        ></span>

                        <div class="space-y-5">
                            <div>
                                <label
                                    for="contacto-nombre"
                                    class="text-fg-subtle block text-xs font-semibold tracking-[0.14em] uppercase"
                                >
                                    {{ $page->nameLabel()->or('Nombre completo') }}
                                </label>
                                <input
                                    id="contacto-nombre"
                                    type="text"
                                    name="name"
                                    required
                                    autocomplete="name"
                                    placeholder="{{ $page->namePlaceholder() }}"
                                    class="bg-surface focus:border-pink-brand/60 focus:bg-surface-2 border-line text-fg placeholder-fg-subtle mt-2 w-full rounded-xl border px-4 py-3 text-sm transition outline-none"
                                />
                            </div>

                            <div>
                                <label
                                    for="contacto-email"
                                    class="text-fg-subtle block text-xs font-semibold tracking-[0.14em] uppercase"
                                >
                                    {{ $page->emailLabel()->or('Correo electrónico') }}
                                </label>
                                <input
                                    id="contacto-email"
                                    type="email"
                                    name="email"
                                    required
                                    autocomplete="email"
                                    placeholder="{{ $page->emailPlaceholder() }}"
                                    class="bg-surface focus:border-pink-brand/60 focus:bg-surface-2 border-line text-fg placeholder-fg-subtle mt-2 w-full rounded-xl border px-4 py-3 text-sm transition outline-none"
                                />
                            </div>

                            <div>
                                <label
                                    for="contacto-curso"
                                    class="text-fg-subtle block text-xs font-semibold tracking-[0.14em] uppercase"
                                >
                                    {{ $page->courseLabel()->or('Curso de interés') }}
                                </label>
                                <div class="relative mt-2">
                                    <select
                                        id="contacto-curso"
                                        name="course"
                                        class="bg-surface focus:border-pink-brand/60 focus:bg-surface-2 border-line text-fg w-full appearance-none rounded-xl border px-4 py-3 text-sm transition outline-none"
                                    >
                                        <option value="">
                                            {{ $page->coursePlaceholder()->or('Selecciona un curso') }}
                                        </option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->title() }}">{{ $course->title() }}</option>
                                        @endforeach
                                        <option value="Todavía no lo sé">Todavía no lo sé</option>
                                    </select>
                                    <svg class="text-fg-subtle pointer-events-none absolute top-1/2 right-4 size-4 -translate-y-1/2" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                        <path d="m4 6 4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>

                            <div>
                                <label
                                    for="contacto-mensaje"
                                    class="text-fg-subtle block text-xs font-semibold tracking-[0.14em] uppercase"
                                >
                                    {{ $page->messageLabel()->or('Mensaje (opcional)') }}
                                </label>
                                <textarea
                                    id="contacto-mensaje"
                                    name="message"
                                    rows="4"
                                    placeholder="{{ $page->messagePlaceholder() }}"
                                    class="bg-surface focus:border-pink-brand/60 focus:bg-surface-2 border-line text-fg placeholder-fg-subtle mt-2 w-full resize-y rounded-xl border px-4 py-3 text-sm transition outline-none"
                                ></textarea>
                            </div>

                            <input
                                type="text"
                                name="website"
                                tabindex="-1"
                                autocomplete="off"
                                aria-hidden="true"
                                class="hidden"
                            />

                            <button type="submit" class="btn btn-primary w-full py-3.5 disabled:opacity-60">
                                <span data-form-label>{{ $page->submitLabel()->or('Enviar mensaje') }}</span>
                                <svg class="size-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                    <path d="M3 8h10m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>

                            <p
                                data-form-feedback
                                role="status"
                                aria-live="polite"
                                class="text-fg min-h-5 text-center text-sm font-medium"
                            ></p>

                            @if ($page->formNote()->isNotEmpty())
                                <p class="text-fg-subtle text-center text-xs">{{ $page->formNote() }}</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
