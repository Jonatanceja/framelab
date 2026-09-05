/**
 * Marca el enlace del menú correspondiente a la sección visible.
 * Solo considera anclas que existen en la página actual; los enlaces
 * a otras páginas se marcan desde el servidor.
 */
export default function initScrollSpy() {
  if (!('IntersectionObserver' in window)) return

  const pairs = [...document.querySelectorAll('[data-nav-link]')]
    .map((link) => {
      const href = link.getAttribute('href') || ''
      const hash = href.indexOf('#')
      if (hash === -1) return null

      const path = href.slice(0, hash)
      if (path && path !== location.pathname) return null

      const section = document.getElementById(href.slice(hash + 1))
      return section ? { link, section } : null
    })
    .filter(Boolean)

  if (!pairs.length) return

  const observer = new IntersectionObserver(
    (entries) => {
      const visible = entries.filter((entry) => entry.isIntersecting).sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0]

      if (!visible) return

      pairs.forEach(({ link, section }) => {
        link.setAttribute('aria-current', String(section === visible.target))
      })
    },
    { rootMargin: '-45% 0px -50% 0px', threshold: [0, 0.2, 0.5] },
  )

  pairs.forEach(({ section }) => observer.observe(section))
}
