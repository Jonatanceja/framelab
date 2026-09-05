@php
    $icons = [
        'guion' => 'M7 3.5H5.5A1.5 1.5 0 0 0 4 5v14a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 20 19V5a1.5 1.5 0 0 0-1.5-1.5H17M8.5 2.5h7v3h-7v-3ZM8 11h8M8 15h5',
        'pincel' => 'M15.5 3.5 20.5 8.5M4 20s3.5.5 5-1 .5-3.5.5-3.5L18 7.5a2.1 2.1 0 0 0-3-3L6.5 13s-2-1-3.5.5S4 20 4 20Z',
        'camara' => 'M3.5 7.5h11v9h-11v-9Zm11 3 6-2.5v8l-6-2.5M6 4.5l2 3m4-3 2 3',
        'presentacion' => 'M3.5 4h17M4.5 4v8.5a1.5 1.5 0 0 0 1.5 1.5h12a1.5 1.5 0 0 0 1.5-1.5V4M12 14v3.5m0 0-3 2.5m3-2.5 3 2.5M8.5 10.5l2.5-2.5 2 2 3-3.5',
    ];
    $path = $icons[$icon] ?? $icons['guion'];
@endphp
<svg viewBox="0 0 24 24" fill="none" class="size-5" aria-hidden="true">
    <path d="{{ $path }}" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
</svg>
