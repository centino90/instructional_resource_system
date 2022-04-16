const mix = require('laravel-mix');
const purgecss = require('@fullhuman/postcss-purgecss')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
.js('resources/js/setup.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/dean.scss', 'public/css')
    .sass('resources/sass/admin.scss', 'public/css')
    .sass('resources/sass/secretary.scss', 'public/css')
    .webpackConfig(require('./webpack.config'));

if (mix.inProduction()) {
    mix.version();
}
