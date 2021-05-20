// @ts-nocheck
let mix = require("laravel-mix");
const ChunkRenamePlugin = require("webpack-chunk-rename-plugin");
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
    '@mixins': __dirname + '/resources/assets/js/mixins',
    '@layout': __dirname + '/resources/assets/js/layout'
    }
  }
});

mix.browserSync({
  proxy: process.env.APP_URL
})
.disableNotifications();


const config = {
  //entry:{},
  output : {
    chunkFilename: 'js/[name].js?id=[chunkhash]', // 
    publicPath: "/"
  },
  plugins: [
    new ChunkRenamePlugin({
    initialChunksWithEntry: true,
    "/js/vendor": "js/vendor.js",
    "/js/app": "js/app.js",
    "/js/manifest": "js/manifest.js",
  })]
};




if (mix.inProduction()) {
    mix.extract(['vue', 'quasar', 'vue-apexcharts', 'vuex', 'moment'])
    .webpackConfig(config)
    .js("resources/assets/js/app.js", "public/js")
    .version();
} else {
  mix.webpackConfig(config)
  .js("resources/assets/js/app.js", "public/js")
  .options({
    processCssUrls: false
  })
  .stylus("resources/assets/stylus/app.styl", "public/css")
  .copy("public/css/app.css", "public/css/app-min.css")
  .copy("resources/assets/stylus/fonts", "public/fonts");

}

//mix.stylus("resources/assets/stylus/app.styl", "public/css", {outputStyle: 'compressed'})
  //.minify('public/css/app.css');
    
  //
