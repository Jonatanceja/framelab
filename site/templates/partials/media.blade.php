@php
    /**
     * Slot de medios: video o imagen.
     *
     * Si hay video se usa el video (en mute y en bucle) y la imagen queda
     * solo como póster mientras carga. Si no hay video, se usa la imagen.
     * Las imágenes siempre se sirven como miniatura WebP (ver site/config/thumbs.php).
     *
     * @var \Kirby\Cms\File|null $image
     * @var \Kirby\Cms\File|null $video
     */
    $image ??= null;
    $video ??= null;
    $alt ??= '';
    $class ??= 'size-full object-cover';
    $sizes ??= '100vw';
    $width ??= 1600;
    $srcset ??= 'default';
    $priority ??= false;
    $placeholder ??= null;
    $placeholderClass ??= 'art-placeholder flex size-full items-center justify-center text-sm text-fg-subtle';

    $poster = $image?->isResizable() ? $image->thumb(['width' => min($width, 1440)])->url() : null;

    /**
     * Punto focal del panel.
     *
     * Kirby lo aplica solo cuando recorta en el servidor (crop). Aquí las
     * imágenes se escalan y se recortan con CSS (object-cover), así que el
     * punto focal se traduce a object-position.
     */
    $focus = $image?->focus()->isNotEmpty()
        ? \Kirby\Image\Focus::normalize($image->focus()->value())
        : null;
@endphp

@if ($video)
    <video
        class="{{ $class }}"
        @if ($focus) style="object-position: {{ $focus }}" @endif
        @if ($poster) poster="{{ $poster }}" @endif
        autoplay
        muted
        loop
        playsinline
        disablepictureinpicture
        preload="{{ $priority ? 'auto' : 'metadata' }}"
        @if ($alt)
            aria-label="{{ $alt }}"
        @else
            aria-hidden="true"
        @endif
        data-autoplay
    >
        <source src="{{ $video->url() }}" type="{{ $video->mime() }}" />
    </video>
@elseif ($image)
    <img
        src="{{ $image->isResizable() ? $image->thumb(['width' => $width])->url() : $image->url() }}"
        @if ($image->isResizable()) srcset="{{ $image->srcset($srcset) }}" sizes="{{ $sizes }}" @endif
        alt="{{ $image->alt()->or($alt) }}"
        class="{{ $class }}"
        @if ($focus) style="object-position: {{ $focus }}" @endif
        @if ($priority)
            fetchpriority="high"
        @else
            loading="lazy"
            decoding="async"
        @endif
    />
@elseif (! is_null($placeholder))
    <div class="{{ $placeholderClass }}">{{ $placeholder }}</div>
@endif
