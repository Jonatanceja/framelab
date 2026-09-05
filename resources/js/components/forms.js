/**
 * Envío de formularios sin recargar la página.
 * Aplica a cualquier <form data-ajax-form> (contacto y newsletter).
 */
export default function initForms() {
  const csrf = document.querySelector('meta[name="csrf-token"]')?.content

  document.querySelectorAll('[data-ajax-form]').forEach((form) => {
    const feedback = form.querySelector('[data-form-feedback]') ?? form.parentElement?.querySelector('[data-form-feedback]')
    const button = form.querySelector('button[type="submit"]')
    const label = form.querySelector('[data-form-label]')
    const originalLabel = label?.textContent

    const say = (message, ok = true) => {
      if (!feedback) return
      feedback.textContent = message
      feedback.classList.toggle('text-white', ok)
      feedback.classList.toggle('text-pink-soft', !ok)
    }

    form.addEventListener('submit', async (event) => {
      event.preventDefault()

      const data = new FormData(form)
      data.append('csrf', csrf ?? '')

      if (button) button.disabled = true
      if (label) label.textContent = 'Enviando…'
      say('')

      try {
        const response = await fetch(form.action, {
          method: 'POST',
          headers: { 'X-Requested-With': 'XMLHttpRequest' },
          body: data,
        })

        const result = await response.json()

        if (response.ok && result.ok) {
          form.reset()
          say(form.dataset.success)
        } else {
          say(result.message || 'Algo salió mal, inténtalo de nuevo.', false)
        }
      } catch (error) {
        say('No pudimos conectar. Revisa tu conexión e inténtalo de nuevo.', false)
      } finally {
        if (button) button.disabled = false
        if (label) label.textContent = originalLabel
      }
    })
  })
}
