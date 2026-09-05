import './bootstrap'

import initTheme from './components/theme'
import initHeader from './components/header'
import initReveal from './components/reveal'
import initScrollSpy from './components/scrollspy'
import initMedia from './components/media'
import initCopy from './components/copy'
import initForms from './components/forms'

const boot = () => {
  initTheme()
  initHeader()
  initReveal()
  initScrollSpy()
  initMedia()
  initCopy()
  initForms()
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', boot, { once: true })
} else {
  boot()
}
