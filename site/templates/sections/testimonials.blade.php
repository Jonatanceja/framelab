@php
    $testimonials = $page->testimonialsList()->toStructure();
    $visible = $page->testimonialsVisible()->toBool(true);
@endphp
@if ($visible && $testimonials->isNotEmpty())
    <section id="testimonios" class="bg-bg-soft border-line relative overflow-hidden border-y py-24 lg:py-32">
        <div
            class="bg-violet-brand/10 pointer-events-none absolute -top-24 right-1/4 h-72 w-72 rounded-full blur-3xl"
        ></div>

        <div class="relative mx-auto max-w-6xl px-5 sm:px-8">
            <h2 class="text-center text-4xl font-extrabold sm:text-5xl" data-reveal>
                {{ $page->testimonialsTitle() }}
                <span class="text-gradient">{{ $page->testimonialsTitleAccent() }}</span>
            </h2>

            <div class="mt-14 grid gap-6 md:grid-cols-2">
                @foreach ($testimonials as $testimonial)
                    <figure
                        class="lift bg-surface border-line relative overflow-hidden rounded-2xl border p-8"
                        data-reveal
                        style="--reveal-delay: {{ 120 * $loop->index }}ms"
                    >
                        <span
                            class="font-display text-brand-text/20 pointer-events-none absolute top-5 right-6 text-6xl leading-none font-black select-none"
                            >”</span
                        >

                        <blockquote class="text-fg relative text-lg leading-relaxed font-medium italic">
                            “{{ $testimonial->quote() }}”
                        </blockquote>

                        <figcaption class="mt-6 flex items-center gap-3 text-sm">
                            <span class="bg-pink-brand h-px w-6"></span>
                            <span
                                class="text-brand-text font-semibold tracking-wide uppercase"
                                >{{ $testimonial->author() }}</span
                            >
                            @if ($testimonial->role()->isNotEmpty())
                                <span class="text-fg-subtle">{{ $testimonial->role() }}</span>
                            @endif
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
    </section>
@endif
