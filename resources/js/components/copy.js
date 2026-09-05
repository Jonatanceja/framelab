/**
 * Botones "Copiar vínculo" del pie de página.
 */
export default function initCopy() {
  document.querySelectorAll('[data-copy]').forEach((button) => {
    const label = button.querySelector('[data-copy-label]')
    const status = button.querySelector('[data-copy-status]')
    const original = label?.textContent

    button.addEventListener('click', async () => {
      const value = button.dataset.copy

      try {
        if (navigator.clipboard) {
          await navigator.clipboard.writeText(value)
        } else {
          const input = document.createElement('input')
          input.value = value
          document.body.append(input)
          input.select()
          document.execCommand('copy')
          input.remove()
        }

        if (label) {
          label.textContent = '¡Copiado!'
          button.classList.add('text-brand-hover')
          setTimeout(() => {
            label.textContent = original
            button.classList.remove('text-brand-hover')
          }, 1800)
        }

        // El cambio de etiqueta no se anuncia solo: hace falta una región viva.
        if (status) {
          status.textContent = `Copiado: ${value}`
          setTimeout(() => {
            status.textContent = ''
          }, 2000)
        }
      } catch (error) {
        if (status) status.textContent = 'No se pudo copiar'
        console.warn('No se pudo copiar', error)
      }
    })
  })
}
