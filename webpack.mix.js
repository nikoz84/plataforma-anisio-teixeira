let mix = require("laravel-mix");
require("dotenv").config();

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

mix.browserSync({
  proxy: process.env.APP_URL
});

mix.config.webpackConfig.output = {
  chunkFilename: "js/[name].vendor.js",
  publicPath: "/"
};

//.extract(["vue", "quasar", "lodash", "axios"]);

mix
  .js("resources/assets/js/app.js", "public/js")
  .stylus("resources/assets/stylus/app.styl", "public/css")
  .version();
