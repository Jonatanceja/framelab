@php
    /**
     * @var Kirby\Cms\Site $site
     * @var Kirby\Cms\Page $current
     *
     * Los metadatos salen de la pestaña SEO de cada página y, si están
     * vacíos, caen a los valores por defecto del sitio (pestaña SEO del sitio).
     */
    $site = site();
    $current = page();

    $pageTitle = $title ?: $current->metaTitle()->or($current->title())->value();
    $metaDescription = $description ?: $current->metaDescription()->or($site->siteDescription())->value();

    $socialTitle = $current->ogTitle()->or($pageTitle)->value();
    $socialDescription = $current->ogDescription()->or($metaDescription)->value();

    $socialImage = $image ?: ($current->ogImage()->toFile() ?? $site->ogImage()->toFile())?->url();

    $locale = $site->siteLocale()->or('es_MX')->value();
    $lang = explode('_', $locale)[0] ?: 'es';
@endphp
<!doctype html>
<html lang="{{ $lang }}" class="no-js scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="@csrf()" />
    <meta name="theme-color" content="#faf9fc" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#0a090c" media="(prefers-color-scheme: dark)" />

    <title>{{ $pageTitle }} | {{ $site->title() }}</title>

    @if ($metaDescription)
        <meta name="description" content="{{ $metaDescription }}" />
    @endif

    <link rel="canonical" href="{{ $current->url() }}" />

    @if ($current->noIndex()->toBool())
        <meta name="robots" content="noindex, follow" />
    @else
        <meta name="robots" content="index, follow, max-image-preview:large" />
    @endif

    <meta property="og:type" content="{{ $current->isHomePage() ? 'website' : 'article' }}" />
    <meta property="og:site_name" content="{{ $site->title() }}" />
    <meta property="og:locale" content="{{ $locale }}" />
    <meta property="og:title" content="{{ $socialTitle }}" />
    <meta property="og:description" content="{{ $socialDescription }}" />
    <meta property="og:url" content="{{ $current->url() }}" />

    <meta name="twitter:card" content="{{ $socialImage ? 'summary_large_image' : 'summary' }}" />
    <meta name="twitter:title" content="{{ $socialTitle }}" />
    <meta name="twitter:description" content="{{ $socialDescription }}" />

    @if ($site->twitterSite()->isNotEmpty())
        <meta name="twitter:site" content="{{ $site->twitterSite() }}" />
    @endif

    @if ($socialImage)
        <meta property="og:image" content="{{ $socialImage }}" />
        <meta property="og:image:alt" content="{{ $socialTitle }}" />
        <meta name="twitter:image" content="{{ $socialImage }}" />
    @endif

    <link rel="icon" href="{{ url('/images/brand/frame-lab-iso.svg') }}" type="image/svg+xml" />

    {{-- Tipografías propias: se precargan para que lleguen junto con el CSS
         y no haya un salto de fuente al pintar. --}}
    <link rel="preload" href="{{ url('/fonts/inter-var.woff2') }}" as="font" type="font/woff2" crossorigin />
    <link rel="preload" href="{{ url('/fonts/archivo-var.woff2') }}" as="font" type="font/woff2" crossorigin />

    <script>
        // Se aplica antes de pintar para que no haya parpadeo de tema.
        document.documentElement.classList.remove('no-js');
        try {
            var theme = localStorage.getItem('fl-theme');
            if (theme === 'light' || theme === 'dark') document.documentElement.dataset.theme = theme;
        } catch (e) {}
    </script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-bg text-fg-muted antialiased">
    <a
        href="#contenido"
        class="focus:bg-pink-deep sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-100 focus:rounded-full focus:px-5 focus:py-2 focus:text-sm focus:font-semibold focus:text-white"
    >
        Saltar al contenido
    </a>

    @include('partials.header')

    <main id="contenido">{{ $slot }}</main>

    @include('partials.footer')
</body>
</html>
