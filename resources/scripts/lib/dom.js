export const getColor = varName => getComputedStyle(document.documentElement).getPropertyValue(`--${varName}`)
export const on = (type, selector, fun) => {
  const listener = event => (
    (
      event.target.matches(selector)
      || event.target.closest(selector)
    )
    && fun(event)
  )

  document.addEventListener(type, listener)

  return () => {
    document.removeEventListener(type, listener)
  }
}
