let mix = require('laravel-mix');

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

mix.autoload({
    'jquery': ['$', 'window.jQuery', "jQuery", "window.$", "jquery", "window.jquery"],
    'popper.js/dist/umd/popper.js': ['Popper', 'window.Popper']
});

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
    .copy('resources/assets/css/print.css', 'public/css')
	.copy('resources/assets/excel/ingresarexcel.xlsx', 'public/storage')
	.copy('resources/leaflet_assets/leaflet.css', 'public/leaflet_assets/leaflet.css')

   .copyDirectory('resources/img', 'public/img')
   .copyDirectory('resources/leaflet_assets/images', 'public/leaflet_assets/images')
   .js('resources/assets/js/jsfunc.js', 'public/js')
   .js('resources/assets/js/components/Map.js', 'public/js/components/Map.js')
   .js('resources/assets/js/components/Mapapp.js', 'public/js/components/Mapapp.js')
   .js('resources/assets/js/index.js', 'public/js/index.js');
   

   mix.browserSync({
    files: [
        'app/**/*',
        'public/**/*',
        'resources/views/**/*',
        'resources/lang/**/*',
        'routes/**/*'
	],
	ignore: [
		'public/temptiles/**/*',
	],
    reloadDelay: 200,
    proxy: 'lsapp3',
    notify: false
    
});

