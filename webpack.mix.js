const mix = require('laravel-mix');


// mix.js('resources/js/app.js', 'public/js')

// mix.js([
//     'resources/js/app.js'
// ], 'public/js/app.js')

// mix.styles([
//     'public/backend/css/styles.css'
// ], 'public/css/app.css');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .options({
        processCssUrls: false
    });
