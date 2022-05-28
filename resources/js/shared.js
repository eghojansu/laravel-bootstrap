import * as bootstrap from 'bootstrap'
import * as lib from '../js-lib'

window.bootstrap = bootstrap
window.lib = lib
window.ready = fun => window.addEventListener('load', (...args) => fun(lib, ...args))
