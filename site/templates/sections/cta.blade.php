<section id="suscribete" class="relative isolate overflow-hidden">
    <div
        class="absolute inset-0 -z-10 bg-[linear-gradient(115deg,#3d2a63_0%,#5a3a7a_38%,#8c4a86_70%,#c04a86_100%)]"
    ></div>
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(70%_120%_at_50%_120%,rgba(10,9,12,0.55),transparent)]"></div>

    <div class="mx-auto max-w-3xl px-5 py-24 text-center sm:px-8 lg:py-28">
        <h2 class="text-4xl font-extrabold text-white sm:text-5xl" data-reveal>{{ $page->ctaTitle() }}</h2>

        <p class="mx-auto mt-5 max-w-xl leading-relaxed text-white/75" data-reveal style="--reveal-delay: 80ms">
            {{ $page->ctaText() }}
        </p>

        <form
            data-ajax-form
            action="{{ url('suscripcion') }}"
            method="post"
            class="mx-auto mt-9 flex w-full max-w-lg flex-col gap-3 sm:flex-row"
            data-success="{{ $page->ctaSuccess()->or('¡Listo! Gracias por suscribirte.') }}"
            data-reveal
            style="--reveal-delay: 160ms"
        >
            <label for="newsletter-email" class="sr-only">Correo electrónico</label>
            <input
                id="newsletter-email"
                type="email"
                name="email"
                required
                autocomplete="email"
                placeholder="{{ $page->ctaPlaceholder()->or('Tu correo electrónico') }}"
                class="w-full rounded-full border border-white/25 bg-white/10 px-6 py-3.5 text-sm text-white placeholder-white/50 backdrop-blur transition outline-none focus:border-white/60 focus:bg-white/15"
            />

            <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" class="hidden" />

            <button
                type="submit"
                class="btn bg-pink-brand hover:bg-pink-bright shrink-0 px-8 text-white shadow-lg shadow-black/25 transition disabled:opacity-60"
            >
                <span data-form-label>{{ $page->ctaButton()->or('Suscribirme') }}</span>
            </button>
        </form>

        <p data-form-feedback role="status" aria-live="polite" class="mt-4 min-h-5 text-sm font-medium text-white"></p>

        @if ($page->ctaNote()->isNotEmpty())
            <p class="mt-1 text-xs text-white/55">{{ $page->ctaNote() }}</p>
        @endif
    </div>
</section>
