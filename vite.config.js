import { createVuePlugin } from 'vite-plugin-vue2'
import laravel from 'laravel-vite-plugin';

export default {
    resolve:{
        dedupe: ['vue', 'vue-router', 'vuex', 'quasar'],
        alias:{
            //'vue$': 'vue/dist/vue.esm.browser',
            '@': __dirname + '/resources/assets/js',
            '@components': __dirname + '/resources/assets/js/components',
            '@composables': __dirname + '/resources/assets/js/composables',
            '@forms': __dirname + '/resources/assets/js/forms',
            '@pages': __dirname + '/resources/assets/js/pages',
            '@mixins': __dirname + '/resources/assets/js/mixins',
            '@layout': __dirname + '/resources/assets/js/layout'
        },
    },
    plugins: [
        createVuePlugin(),
        laravel([
                'resources/assets/js/app.js',
            ]),
    ],
}
