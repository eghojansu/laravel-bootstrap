import * as bootstrap from 'bootstrap'
import * as lib from './lib'
import './common.sass'

window.bootstrap = bootstrap
window.lib = lib
window.ready = fun => window.addEventListener('load', (...args) => fun(lib, ...args))
