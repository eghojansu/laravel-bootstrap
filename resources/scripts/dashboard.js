ready(({
  dom: {
    query: q,
  },
  alert: {
    confirm,
    notify,
  },
  common: {
    request,
  },
}) => {
  q('[data-confirm]').on('click', async ({ event, dom: { element } }) => {
    event.preventDefault()

    const { isConfirmed, value: { success, message, data: { redirect } = {} } = {} } = await confirm(
      () =>request({
        url: element.href,
        method: element.dataset.confirm,
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
})
