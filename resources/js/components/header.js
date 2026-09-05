/**
 * Header fijo: fondo al hacer scroll + menú móvil.
 */
export default function initHeader() {
  const header = document.querySelector('[data-header]')
  if (!header) return

  const solidClasses = ['bg-bg/85', 'backdrop-blur-xl', 'border-line']

  const onScroll = () => {
    header.classList.toggle('shadow-lg', window.scrollY > 8)
    solidClasses.forEach((cls) => header.classList.toggle(cls, window.scrollY > 8))
  }

  onScroll()
  window.addEventListener('scroll', onScroll, { passive: true })

  const toggle = header.querySelector('[data-menu-toggle]')
  const panel = header.querySelector('[data-menu-panel]')
  if (!toggle || !panel) return

  const iconOpen = toggle.querySelector('[data-icon-open]')
  const iconClose = toggle.querySelector('[data-icon-close]')

  const setMenu = (open) => {
    panel.hidden = !open
    toggle.setAttribute('aria-expanded', String(open))
    toggle.querySelector('.sr-only').textContent = open ? 'Cerrar menú' : 'Abrir menú'
    iconOpen?.classList.toggle('hidden', open)
    iconClose?.classList.toggle('hidden', !open)
    document.body.classList.toggle('overflow-hidden', open)
  }

  toggle.addEventListener('click', () => setMenu(panel.hidden))

  panel.querySelectorAll('[data-menu-link]').forEach((link) => {
    link.addEventListener('click', () => setMenu(false))
  })

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && !panel.hidden) {
      setMenu(false)
      toggle.focus()
    }
  })

  window.addEventListener('resize', () => {
    if (window.innerWidth >= 1024 && !panel.hidden) setMenu(false)
  })
}
