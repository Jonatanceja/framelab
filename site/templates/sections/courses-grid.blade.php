@php
    $courses = $page->children()->listed();

    // Con pocos cursos la rejilla se centra en vez de dejar huecos a la derecha.
    $grid = match ($courses->count()) {
        1 => 'max-w-sm mx-auto',
        2 => 'max-w-3xl mx-auto md:grid-cols-2',
        default => 'md:grid-cols-2 lg:grid-cols-3',
    };
@endphp
<section id="lista" class="relative pt-12 pb-24 lg:pt-16 lg:pb-32">
    <div class="mx-auto max-w-7xl px-5 sm:px-8">
        {{-- Da nombre a la lista y evita el salto de h1 a h3 --}}
        <h2 class="sr-only">Todos los cursos</h2>

        @if ($courses->isNotEmpty())
            <div class="grid gap-6 {{ $grid }}">
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
        @else
            <p class="bg-surface border-line text-fg-subtle rounded-2xl border p-10 text-center text-sm">
                Todavía no hay cursos publicados.
            </p>
        @endif
    </div>
</section>
