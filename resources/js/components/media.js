/**
 * Los videos de fondo van en mute y en bucle. Si el sistema pide menos
 * movimiento, se pausan y se queda el póster.
 */
export default function initMedia() {
  const videos = document.querySelectorAll('video[data-autoplay]')
  if (!videos.length) return

  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)')

  const sync = () => {
    videos.forEach((video) => {
      video.muted = true
      video.loop = true

      if (reduced.matches) {
        video.pause()
        video.removeAttribute('autoplay')
      } else {
        const played = video.play()
        if (played?.catch) played.catch(() => {})
      }
    })
  }

  sync()
  reduced.addEventListener?.('change', sync)
}
