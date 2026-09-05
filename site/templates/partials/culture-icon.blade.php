@php
    $icons = [
        'comunidad' => 'M9 11a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm7.5 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM2.5 20v-1a5.5 5.5 0 0 1 5.5-5.5h2A5.5 5.5 0 0 1 15.5 19v1M17 13.2a5 5 0 0 1 4.5 4.98V20',
        'innovacion' => 'M9 18h6m-5 2.5h4M12 3a6 6 0 0 1 3.6 10.8c-.6.45-.95 1.05-1.05 1.7l-.1.5H9.55l-.1-.5c-.1-.65-.45-1.25-1.05-1.7A6 6 0 0 1 12 3Z',
        'industria' => 'M3 20V9.5l5.5 3.2V9.5l5.5 3.2V4.5h4.5V20M3 20h18M7.5 16.5h1.5m4 0h1.5',
        'portafolio' => 'M3.5 8.5h17v10a1.5 1.5 0 0 1-1.5 1.5H5a1.5 1.5 0 0 1-1.5-1.5v-10Zm5-1.5V5.5A1.5 1.5 0 0 1 10 4h4a1.5 1.5 0 0 1 1.5 1.5V7M3.5 12.5h17',
        'mentoria' => 'M12 3.5 21 8l-9 4.5L3 8l9-4.5ZM6.5 10.5V15c0 1.5 2.5 3 5.5 3s5.5-1.5 5.5-3v-4.5M21 8v6',
    ];
    $path = $icons[$icon] ?? $icons['comunidad'];
@endphp
<svg viewBox="0 0 24 24" fill="none" class="size-5" aria-hidden="true">
    <path d="{{ $path }}" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
</svg>
