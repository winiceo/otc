let mix = require('laravel-mix');
const path = require('path');

mix.setPublicPath('assets');
mix.setResourceRoot('/assets/web');
mix.sourceMaps(! mix.inProduction());


mix.webpackConfig({
    output: {

        chunkFilename: '[name].[chunkhash].js'
    },
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

mix.js('resources/assets/js/app.js', 'assets')
    .extract(['vue'])

    .sass('resources/assets/sass/app.scss', 'assets');

mix.js('resources/assets/admin/js/admin.js', 'assets')
    .sass('resources/assets/admin/sass/admin.scss', 'assets')
    .copy('node_modules/trumbowyg/dist/ui/icons.svg', 'assets/js/ui/icons.svg');
