const mix = require('laravel-mix');

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

mix
    .sass('resources/views/scss/bootstrap.scss', 'public/site/style.css')
    .sass('node_modules/@fortawesome/fontawesome-free/scss/fontawesome.scss', 'public/site/fontawesome.css')
    .sass('resources/views/scss/style_login.scss', 'public/site/style_login.css')

    .scripts('node_modules/jquery/dist/jquery.js', 'public/site/jquery.js')
    .scripts('node_modules/jquery-form/dist/jquery.form.min.js', 'public/site/jquery-form.js')
    .scripts('node_modules/bootstrap/dist/js/bootstrap.bundle.js', 'public/site/bootstrap.js')
    .scripts('node_modules/@fortawesome/fontawesome-free/js/all.js', 'public/site/fontawesome.js')
    .scripts('node_modules/jquery-mask-plugin/dist/jquery.mask.min.js', 'public/site/jquery-mask.js');