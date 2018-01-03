let mix = require('laravel-mix');
let path = require('path');

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

mix.setPublicPath(path.join('public', 'assets'));
mix.setResourceRoot('/assets/');
mix.sourceMaps(! mix.inProduction());
mix.disableNotifications();

if (mix.config.hmr === true) {
  mix.setResourceRoot('/');
}

/*
 |--------------------------------------------------------------------------
 | Bootstrap SASS & jQuery bundle.
 |--------------------------------------------------------------------------
 |
 | 包含 jQuery 和 Bootstrap 的捆包。
 |
 */

mix.sass('resources/assets/sass/bootstrap.scss', path.join('public', 'assets', 'css'))
   .js('resources/assets/js/bootstrap.js', path.join('public', 'assets', 'js'))


/*
 |--------------------------------------------------------------------------
 | 后台可运行 js 捆
 |--------------------------------------------------------------------------
 |
 | 不包含 jQuery 和 Bootstrap 的 vue 捆包。
 |
 */

mix.js('resources/assets/admin', path.join('public', 'assets', 'js'));

/*
 |--------------------------------------------------------------------------
 | Installer 打包
 |--------------------------------------------------------------------------
 |
 | element-ui
 |
 */

mix.js('resources/assets/installer/main.js', path.join('public', 'assets', 'js', 'installer.js'));
mix.copy('resources/assets/installer/logo.png', path.join('public', 'assets', 'installer', 'logo.png'));




 mix.webpackConfig({

    resolve: {
        alias: {
            'components': 'assets/js/components',
            'config': 'assets/js/config',
            'lang': 'assets/js/lang',
            'plugins': 'assets/js/plugins',
            'vendor': 'assets/js/vendor',
            'views': 'assets/js/views',
            'dashboard': 'assets/js/views/dashboard',
        },
        modules: [
            'node_modules',
            path.resolve(__dirname, "resources")
        ]
    },
})


mix.js('resources/assets/js/app.js', 'public/js')
    .extract(['vue'])

    .sass('resources/assets/sass/app.scss', 'public/css');
//
// mix.js('resources/assets/admin/js/admin.js', 'public/js')
//     .sass('resources/assets/admin/sass/admin.scss', 'public/css')
//     .copy('node_modules/trumbowyg/dist/ui/icons.svg', 'public/js/ui/icons.svg');
