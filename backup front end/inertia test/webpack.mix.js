const { extract } = require('laravel-mix');
const mix = require('laravel-mix');
const path = require('path');

mix.disableNotifications();

mix.alias({
    ziggy: path.resolve('vendor/tightenco/ziggy/dist'),
});

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css')
    .webpackConfig({
        output: { chunkFilename: 'js/[name].js?id=[chunkhash]' },
        resolve: {
          alias: {
            vue$: 'vue/dist/vue.runtime.js',
            '@': path.resolve('resources/js'),
            '@components': path.resolve('/resources/js/Components'),
            '@forms': path.resolve('/resources/js/Forms'),
            '@pages': path.resolve('/resources/js/Pages'),

          },
        }
    })
    .extract()
    .version()
    .sourceMaps();
