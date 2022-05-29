export const getColor = varName => getComputedStyle(document.documentElement).getPropertyValue(`--${varName}`)
export const query = selector => {
  const dom = {
    _cache: {},
    get element() {
      return dom._cache.element || document.querySelector(selector)
    },
    get elements() {
      return document.querySelectorAll(selector)
    },
    _withElement: element => {
      dom._cache.element = element

      return dom
    },
    attr: (name, set) => {
      if (set) {
        if ('function' === typeof set) {
          dom.element.setAttribute(name, set(dom.element.getAttribute(name)))

          return dom
        }

        dom.element.setAttribute(name, set)

        return dom
      }

      return dom.element.getAttribute(name)
    },
    data: (name, set) => {
      if (set) {
        if ('function' === typeof set) {
          dom.element.dataset[name] = set(dom.element.dataset[name])

          return dom
        }

        dom.element.dataset[name] = set

        return dom
      }

      return dom.element.dataset[name]
    },
    prop: (name, set) => {
      if (set) {
        if ('function' === typeof set) {
          dom.element[name] = set(dom.element[name])

          return dom
        }

        dom.element[name] = set

        return dom
      }

      return dom.element[name]
    },
    on: (type, fun) => {
      document.addEventListener(type, event => {
        if (event.target.matches(selector)) {
          fun({ event, dom: dom._withElement(event.target) })
        }
      })

      return dom
    },
  }

  return dom
}
