/**
 * Aparición progresiva de los elementos con [data-reveal].
 */
export default function initReveal() {
  const items = document.querySelectorAll('[data-reveal]')
  if (!items.length) return

  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches

  if (reduced || !('IntersectionObserver' in window)) {
    items.forEach((item) => item.classList.add('is-visible'))
    return
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return
        entry.target.classList.add('is-visible')
        observer.unobserve(entry.target)
      })
    },
    { rootMargin: '0px 0px -12% 0px', threshold: 0.12 },
  )

  items.forEach((item) => observer.observe(item))
}
