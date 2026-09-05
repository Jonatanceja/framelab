/**
 * Selector de tema: sistema → claro → oscuro → sistema.
 * La preferencia se guarda en localStorage; "sistema" no guarda nada,
 * así que el sitio sigue al sistema operativo mientras no se elija otra cosa.
 */
const KEY = 'fl-theme'
const MODES = ['system', 'light', 'dark']
const LABELS = {
  system: 'Tema: sistema. Cambiar a claro',
  light: 'Tema: claro. Cambiar a oscuro',
  dark: 'Tema: oscuro. Cambiar a automático',
}

const read = () => {
  try {
    const stored = localStorage.getItem(KEY)
    return MODES.includes(stored) ? stored : 'system'
  } catch (error) {
    return 'system'
  }
}

const write = (mode) => {
  try {
    if (mode === 'system') localStorage.removeItem(KEY)
    else localStorage.setItem(KEY, mode)
  } catch (error) {
    /* modo privado: el tema dura solo esta visita */
  }
}

export default function initTheme() {
  const button = document.querySelector('[data-theme-toggle]')
  let mode = read()

  const apply = () => {
    const root = document.documentElement

    if (mode === 'system') delete root.dataset.theme
    else root.dataset.theme = mode

    if (!button) return

    button.querySelectorAll('[data-theme-icon]').forEach((icon) => {
      icon.classList.toggle('hidden', icon.dataset.themeIcon !== mode)
    })

    button.setAttribute('title', LABELS[mode].split('.')[0])
    const label = button.querySelector('[data-theme-label]')
    if (label) label.textContent = LABELS[mode]
  }

  apply()

  button?.addEventListener('click', () => {
    mode = MODES[(MODES.indexOf(mode) + 1) % MODES.length]
    write(mode)
    apply()
  })
}
