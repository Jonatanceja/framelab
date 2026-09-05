@php
    $menu = site()->menu()->toStructure();

    /** Marca el enlace de la página actual; las anclas las resuelve el scroll-spy. */
    $isCurrent = function (string $link): bool {
        $link = trim($link);

        if ($link === '' || str_starts_with($link, '#') || str_starts_with($link, 'http')) {
            return false;
        }

        $path = trim((string) parse_url($link, PHP_URL_PATH), '/');
        $uri = page()->uri();

        // También marca la sección cuando estamos en una página hija.
        return $path !== '' && ($path === $uri || str_starts_with($uri, $path.'/'));
    };
@endphp
<header
    data-header
    class="fixed inset-x-0 top-0 z-50 border-b border-transparent transition-[background-color,border-color,backdrop-filter] duration-300"
>
    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between gap-6 px-5 sm:px-8">
        <a
            href="{{ url('/') }}"
            class="flex items-center gap-3 transition-opacity hover:opacity-80"
            aria-label="Frame Lab — inicio"
        >
            <img src="{{ url('/images/brand/frame-lab-iso.svg') }}" alt="" class="h-7 w-auto" />
            <img
                src="{{ url('/images/brand/frame-lab-logo-ink.svg') }}"
                alt="Frame Lab Animation School"
                class="logo-light h-4 w-auto sm:h-[18px]"
            />
            <img src="{{ url('/images/brand/frame-lab-logo.svg') }}" alt="" class="logo-dark h-4 w-auto sm:h-[18px]" />
        </a>

        <nav class="hidden items-center gap-8 lg:flex" aria-label="Navegación principal">
            @foreach ($menu as $item)
                <a
                    href="{{ $item->link() }}"
                    data-nav-link
                    @if ($isCurrent($item->link()->value())) aria-current="page" @endif
                    class="group aria-[current=page]:text-brand-hover text-fg-muted hover:text-fg relative text-sm font-medium transition-colors"
                >
                    {{ $item->label() }}
                    <span
                        class="bg-pink-bright absolute -bottom-1.5 left-0 h-px w-0 transition-all duration-300 group-hover:w-full group-aria-[current=page]:w-full"
                    ></span>
                </a>
            @endforeach
        </nav>

        <div class="flex items-center gap-3">
            @if (site()->navCtaLabel()->isNotEmpty())
                <a href="{{ site()->navCtaLink()->or('#suscribete') }}" class="btn btn-primary hidden sm:inline-flex">
                    {{ site()->navCtaLabel() }}
                    <svg class="size-3.5" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M3 8h10m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            @endif

            <button
                type="button"
                data-theme-toggle
                title="Tema"
                class="border-line bg-fill text-fg-muted hover:bg-fill-strong hover:text-fg inline-flex size-11 items-center justify-center rounded-full border transition"
            >
                <span class="sr-only" data-theme-label>Cambiar tema</span>

                <svg data-theme-icon="system" class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <rect x="2.75" y="4.25" width="18.5" height="12.5" rx="2" stroke="currentColor" stroke-width="1.6" />
                    <path d="M8.5 20.25h7M12 17v3.25" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                </svg>

                <svg data-theme-icon="light" class="hidden size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <circle cx="12" cy="12" r="4.25" stroke="currentColor" stroke-width="1.6" />
                    <path
                        d="M12 2.75v2m0 14.5v2M21.25 12h-2m-14.5 0h-2m14.28-6.53-1.42 1.42M7.89 16.11l-1.42 1.42m12.06 0-1.42-1.42M7.89 7.89 6.47 6.47"
                        stroke="currentColor"
                        stroke-width="1.6"
                        stroke-linecap="round"
                    />
                </svg>

                <svg data-theme-icon="dark" class="hidden size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path
                        d="M20 14.2A8.2 8.2 0 0 1 9.8 4a8.25 8.25 0 1 0 10.2 10.2Z"
                        stroke="currentColor"
                        stroke-width="1.6"
                        stroke-linejoin="round"
                    />
                </svg>
            </button>

            <button
                type="button"
                data-menu-toggle
                aria-expanded="false"
                aria-controls="menu-movil"
                class="border-line bg-fill text-fg hover:bg-fill-strong inline-flex size-11 items-center justify-center rounded-full border transition lg:hidden"
            >
                <span class="sr-only">Abrir menú</span>
                <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path data-icon-open d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                    <path data-icon-close class="hidden" d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                </svg>
            </button>
        </div>
    </div>

    <div id="menu-movil" data-menu-panel hidden class="bg-bg/95 border-line border-t backdrop-blur-xl lg:hidden">
        <nav class="mx-auto flex max-w-7xl flex-col gap-1 px-5 py-5 sm:px-8" aria-label="Navegación móvil">
            @foreach ($menu as $item)
                <a
                    href="{{ $item->link() }}"
                    data-menu-link
                    @if ($isCurrent($item->link()->value())) aria-current="page" @endif
                    class="aria-[current=page]:text-brand-hover text-fg-muted hover:bg-fill hover:text-fg rounded-xl px-4 py-3 text-lg font-medium transition"
                >
                    {{ $item->label() }}
                </a>
            @endforeach

            @if (site()->navCtaLabel()->isNotEmpty())
                <a
                    href="{{ site()->navCtaLink()->or('#suscribete') }}"
                    data-menu-link
                    class="btn btn-primary mt-3 w-full"
                >
                    {{ site()->navCtaLabel() }}
                </a>
            @endif
        </nav>
    </div>
</header>
