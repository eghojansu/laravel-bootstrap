require('dotenv').config()

const mix = require('laravel-mix')
const dev = ['local', 'dev', 'development'].includes(process.env.APP_ENV)
const url = process.env.APP_URL
  .replace('${SERVER_HOST}', process.env.SERVER_HOST)
  .replace('${SERVER_PORT}', process.env.SERVER_PORT)

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
  .js('resources/js/shared.js', 'public/assets')
  .js('resources/js/dashboard.js', 'public/assets')
  .sass('resources/css/shared.sass', 'public/assets')
  .sourceMaps(dev)
  .browserSync({
    proxy: url,
    open: false,
  })
