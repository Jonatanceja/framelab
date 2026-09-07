@php
    /**
     * Los mentores se eligen en el panel entre las fichas hijas de esta página.
     * Si no se elige ninguna se muestran todas.
     */
    $mentors = $page->mentorsList()->toPages();

    if ($mentors->isEmpty()) {
        $mentors = $page->children()->listed();
    }

    // Con un solo mentor no hay bento que armar: la tarjeta conserva su tamaño
    // (dos columnas si es destacada, una si no) y se centra en la retícula.
    $single = $mentors->count() === 1;
    $singleCard = $single ? $mentors->first()->card()->or('perfil')->value() : null;

    $gridClass = match (true) {
        $singleCard === 'destacado' => 'lg:mx-auto lg:w-2/3',
        $single => 'lg:mx-auto lg:w-1/3',
        default => 'lg:grid-cols-3',
    };
@endphp
@if ($mentors->isNotEmpty())
    <section id="mentores" class="border-line bg-bg-soft relative border-y py-24 lg:py-32">
        <div class="mx-auto max-w-7xl px-5 sm:px-8">
            <div class="mx-auto max-w-2xl text-center" data-reveal>
                <h2 class="text-4xl font-extrabold sm:text-5xl">
                    {{ $page->mentorsTitle() }} <span class="text-gradient">{{ $page->mentorsTitleAccent() }}</span>
                </h2>
                <p class="text-fg-muted mx-auto mt-5 leading-relaxed">{{ $page->mentorsText() }}</p>
            </div>

            <div class="mt-14 grid gap-6 {{ $gridClass }}">
                @foreach ($mentors as $mentor)
                    @include('partials.mentor-card', ['mentor' => $mentor, 'index' => $loop->index, 'single' => $single])
                @endforeach
            </div>
        </div>
    </section>
@endif
