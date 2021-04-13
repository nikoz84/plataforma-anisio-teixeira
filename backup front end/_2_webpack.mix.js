// @ts-nocheck
const mix = require("laravel-mix");
const path = require('path');


mix.browserSync({
  proxy: process.env.APP_URL
});

mix.disableNotifications();

mix.override((config) => {
    delete config.watchOptions;
});
if(!mix.inProduction()){
mix
  .js("resources/js/app.js", "public/js")
  .stylus("resources/stylus/app.styl", "public/css")
  .webpackConfig({
    output: { chunkFilename: 'js/[name].[contenthash].js' },
    resolve: {
      alias: {
        vue$: 'vue/dist/vue.runtime.js',
        '@': path.resolve('resources/js'),
        '@components': path.resolve('/resources/js/Components'),
        '@forms': path.resolve('/resources/js/Forms'),
        '@pages': path.resolve('/resources/js/Pages'),
      
      },
    },
  })
  .babelConfig({
    "presets": ["@babel/preset-env"],
    plugins: [
      "@babel/plugin-syntax-dynamic-import", 
      "@babel/plugin-proposal-object-rest-spread"
    ],
  })
  .version()
  .sourceMaps();
} else {
   mix
    .webpackConfig({
      output: {
        filename: "[name].js",
        chunkFilename: "js/[name].js"
      }
    })
    .js(["resources/assets/js/app.js"], "public/js")
    .stylus("resources/stylus/app.styl", "public/css")
    .extract()
    ;
}