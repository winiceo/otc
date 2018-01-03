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
    output: {
        publicPath: "/web",
        chunkFilename: 'web/js/[name].[chunkhash].js'
    },
    resolve: {
        alias: {
            'components': 'assets/web/js/components',
            'config': 'assets/web/js/config',
            'lang': 'assets/web/js/lang',
            'plugins': 'assets/web/js/plugins',
            'vendor': 'assets/web/js/vendor',
            'views': 'assets/web/js/views',
            'dashboard': 'assets/web/js/views/dashboard',
        },
        modules: [
            'node_modules',
            path.resolve(__dirname, "resources")
        ]
    },
})


mix.js('resources/assets/web/js/app.js', 'web/js')
    .extract(['vue'])

    .sass('resources/assets/web/sass/app.scss', 'web/css');
