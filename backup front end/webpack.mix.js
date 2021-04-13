const mix = require("laravel-mix");
const webpack = require('webpack')

mix.disableNotifications();

mix.webpackConfig ({
  plugins: [
    new webpack.DefinePlugin({
      __VUE_OPTIONS_API__: true,
      __VUE_PROD_DEVTOOLS__: false,
    }),
  ],
})

mix.browserSync({
  proxy: process.env.APP_URL
});

mix.js('resources/js/app.js', 'public/js')
.vue()
.sourceMaps().extract(['vue'])

mix.postCss("resources/css/app.css", "public/css", [
     require("tailwindcss"),
    ]);