let mix = require("laravel-mix");
//const ChunkRenamePlugin = require("webpack-chunk-rename-plugin");
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

mix.webpackConfig({
  resolve: {
    extensions: ['.js', '.vue', '.json'],
    alias: {
      'vue$': 'vue/dist/vue.esm.js',
      '@': __dirname + '/resources/assets/js',
      '@components': __dirname + '/resources/assets/js/components',
      '@composables': __dirname + '/resources/assets/js/composables',
      '@forms': __dirname + '/resources/assets/js/forms',
      '@pages': __dirname + '/resources/assets/js/pages',
      '@mixins': __dirname + '/resources/assets/js/mixins'
      
    },
  },
});



mix.browserSync({
  proxy: process.env.APP_URL
});

mix.disableNotifications();

if (!mix.inProduction()) {
  mix.config.webpackConfig.output = {
    chunkFilename: "js/[name].min.js",
    publicPath: "/"
  };
  mix
    .js("resources/assets/js/app.js", "public/js")
    .stylus("resources/assets/stylus/app.styl", "public/css");
    //.version();

  //mix.copy("public/css/app.css", "public/css/app-copy.css");
} else {
  mix
    .webpackConfig({
      output: {
        filename: "[name].js",
        chunkFilename: "js/[name].js"
      }
    })
    .js(["resources/assets/js/app.js"], "public/js")
    .extract();
  //mix.copy("public/js/js/app.vendor.js", "public/js/");
  //mix.styles(["public/css/app-copy.css"], "public/css/app.css");
}