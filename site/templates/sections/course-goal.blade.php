@if ($page->goalText()->isNotEmpty())
    <section class="bg-bg-soft border-line border-y py-20 lg:py-24">
        <div class="mx-auto max-w-3xl px-5 text-center sm:px-8">
            <h2 class="text-3xl font-extrabold sm:text-4xl" data-reveal>
                {{ $page->goalTitle() }} <span class="text-gradient">{{ $page->goalTitleAccent() }}</span>
            </h2>

            <p class="text-fg-muted mx-auto mt-6 max-w-2xl leading-relaxed" data-reveal style="--reveal-delay: 80ms">
                {{ $page->goalText() }}
            </p>
        </div>
    </section>
@endif
