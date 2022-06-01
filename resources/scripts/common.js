import './common.sass'

ready(({
  dom: {
    on,
  },
  alert: {
    confirm,
    notify,
  },
  common: {
    request,
    random,
  },
}) => {
  const toggleFeedback = el => {
    const $parent = el.closest('div')

    if (!el.validationMessage) {
      el.classList.remove('is-invalid')
      $parent.classList.remove('has-validation')

      return
    }

    const $feedback = $parent.querySelector('.invalid-feedback')

    if ($feedback) {
      $feedback.innerHTML = el.validationMessage
    } else {
      const $newFeedback = document.createElement('div')

      $newFeedback.classList.add('invalid-feedback')
      $newFeedback.innerHTML = el.validationMessage

      $parent.append($newFeedback)
    }

    $parent.classList.add('has-validation')
    el.classList.add('is-invalid')
  }
  on('click', '[data-confirm]', async event => {
    event.preventDefault()

    const { target: el } = event
    const { isConfirmed, value: { success, message, data: { redirect } = {} } = {} } = await confirm(
      () => request({
        url: el.href,
        method: el.dataset.confirm,
      })
    )

    if (isConfirmed && message) {
      notify(message, success)

      setTimeout(() => {
        if (redirect) {
          window.location.assign(redirect)
        } else {
          window.location.reload()
        }
      }, 1000)
    }
  })
  on('submit', '[novalidate]', event => {
    const { target: form } = event

    if (form.checkValidity()) {
      return
    }

    event.preventDefault()
    event.stopPropagation()

    form.querySelectorAll('.form-control, .form-control-check').forEach(toggleFeedback)
  })
  on('input', '[novalidate] input.form-control', ({ target }) => toggleFeedback(target))
  on('click', '.input-group [data-id="toggle-password"]', event => {
    event.preventDefault()

    const $target = event.target.closest('[data-id="toggle-password"]')
    const $input = $target.closest('.input-group').querySelector('.form-control')
    const $icon = $target.querySelector('i[class*="bi-"')
    const raw = 'text' === $input.type

    $input.type = raw ? 'password' : 'text'

    if ($icon) {
      $icon.classList.remove('bi-eye', 'bi-eye-slash')
      $icon.classList.add(raw ? 'bi-eye' : 'bi-eye-slash')
    }
  })
  on('click', '.input-group [data-id="create-password"]', event => {
    event.preventDefault()

    const $input = event.target.closest('.input-group').querySelector('.form-control')

    $input.value = random(8)
  })
})
