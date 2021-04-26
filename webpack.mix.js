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

mix.js('resources/js/app.js', 'public/js').vue();
mix.sass('resources/sass/app.scss', 'public/css')
    .css('./resources/js/assets/fontawesome-free/css/');

    // mix.styles([
    //     'resources/assets/fontawesome-free/css/all.min.css',
    //     'resources/assets/css/styles.css',
    //     'https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css'
    // ], 'public/css');
