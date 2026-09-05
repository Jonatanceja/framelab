@php
    $faqs = $page->faqList()->toStructure();
@endphp
@if ($faqs->isNotEmpty())
    <section id="faq" class="bg-bg-soft border-line border-t py-24 lg:py-32">
        <div class="mx-auto max-w-3xl px-5 sm:px-8">
            <div class="text-center" data-reveal>
                <h2 class="text-3xl font-extrabold sm:text-4xl">
                    {{ $page->faqTitle() }} <span class="text-gradient">{{ $page->faqTitleAccent() }}</span>
                </h2>
                <p class="text-fg-muted mx-auto mt-5 max-w-xl leading-relaxed">{{ $page->faqText() }}</p>
            </div>

            <div class="mt-12 space-y-3">
                @foreach ($faqs as $faq)
                    <details
                        class="group lift bg-surface border-line open:border-line-strong overflow-hidden rounded-2xl border"
                        data-reveal
                        style="--reveal-delay: {{ 80 * $loop->index }}ms"
                    >
                        <summary
                            class="group-open:text-brand-hover text-fg flex cursor-pointer list-none items-center justify-between gap-5 p-6 text-base font-semibold marker:content-none"
                        >
                            {{ $faq->question() }}

                            <span
                                class="group-open:border-pink-brand/50 group-open:text-brand-hover border-line text-fg-muted ease-soft inline-flex size-8 shrink-0 items-center justify-center rounded-full border transition duration-500 group-open:rotate-45"
                            >
                                <svg class="size-3.5" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                    <path d="M8 3v10M3 8h10" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" />
                                </svg>
                            </span>
                        </summary>

                        <p class="text-fg-muted px-6 pb-6 text-sm leading-relaxed">{{ $faq->answer() }}</p>
                    </details>
                @endforeach
            </div>
        </div>
    </section>
@endif
