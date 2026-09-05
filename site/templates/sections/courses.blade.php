@php
    /**
     * Los cursos se eligen en el panel desde la página Cursos.
     * Si no se elige ninguno se muestran los primeros tres.
     */
    $courses = $page->coursesList()->toPages();

    if ($courses->isEmpty()) {
        $courses = page('cursos')?->children()->listed()->limit(3) ?? new Kirby\Cms\Pages;
    }

    // Con pocos cursos la rejilla se centra en vez de dejar huecos a la derecha.
    $grid = match ($courses->count()) {
        1 => 'max-w-sm mx-auto',
        2 => 'max-w-3xl mx-auto md:grid-cols-2',
        default => 'md:grid-cols-2 lg:grid-cols-3',
    };
@endphp
<section id="cursos" class="relative py-24 lg:py-32">
    <div class="mx-auto max-w-7xl px-5 sm:px-8">
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <h2 class="text-4xl font-extrabold sm:text-5xl">
                {{ $page->coursesTitle() }} <span class="text-gradient">{{ $page->coursesTitleAccent() }}</span>
            </h2>
            <p class="text-fg-muted mx-auto mt-5 max-w-xl leading-relaxed">{{ $page->coursesText() }}</p>
        </div>

        @if ($courses->isNotEmpty())
            <div class="mt-14 grid gap-6 {{ $grid }}">
                @foreach ($courses as $course)
                    @include('partials.course-card', [
                        'cardTitle' => $course->title()->value(),
                        'cardTagline' => $course->tagline()->value(),
                        'cardDuration' => $course->duration()->value(),
                        'cardSchedule' => $course->schedule()->value(),
                        'cardMentor' => $course->instructorName()->value(),
                        'cardMentorRole' => $course->instructorBadge()->value(),
                        'cardImage' => $course->cardImage()->toFile(),
                        'cardLink' => $course->url(),
                        'cardIndex' => $loop->index,
                    ])
                @endforeach
            </div>

            @if ($coursesPage = page('cursos'))
                <div class="mt-12 text-center" data-reveal>
                    <a href="{{ $coursesPage->url() }}" class="btn btn-ghost">Ver todos los cursos</a>
                </div>
            @endif
        @endif
    </div>
</section>
