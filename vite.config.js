import vue from '@vitejs/plugin-vue2'
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';
import { resolve } from 'path'


export default defineConfig({
    publicDir: false,
    optimizeDeps: {
        include: [
            'vue',
            'vue-router',
            'vuex',
            'axios',
            'quasar'
        ]
    },
    build: {
        manifest: true,
        outDir: 'public/build',
        rollupOptions: {
            input: 'resources/js/app.js',
        }
    },
    plugins: [
        laravel([
            'resources/js/app.js',
            'resources/stylus/app.styl'
        ]),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        })
    ],
    resolve: {
        alias: {
            '@' : resolve(__dirname, '/resources/js'),
            '~@': resolve(__dirname,  '/resources/stylus'),
            '~quasar': resolve(__dirname, 'node_modules/quasar'),
            '@quasar': resolve(__dirname, 'node_modules/@quasar')
        },
    },
    css: {
        preprocessorOptions: {
            styl: {
                //additionalData: '@import "@scss/shared.scss";'
            }
        }
    }
});


/*
export default ({command}) => ({
    base: command === 'serve' ? '' : '/build/',
    publicDir: false,
    build: {
        manifest: true,
        outDir: 'public/build',
        rollupOptions: {
            input: 'resources/js/app.js',
        }
    },
    resolve:{
        alias:{
            '@': __dirname + '/resources/js',
        },
    },
    plugins: [
        createVuePlugin(),
        laravel('resources/js/app.js')
    ]
});


export default defineConfig({
    resolve:{
        
        alias:{
            '@': __dirname + '/resources/assets/js',
        },
    },
    optimizeDeps: {
        include: [
            //'vue',
            //'axios'
        ]
    },
    plugins: [
        createVuePlugin({
            template: {
                compilerOptions: {
                    compatConfig: {
                        MODE: 2
                    }
                }
            }
        }),
        dynamicImport(),
        laravel([
                'resources/assets/js/app.js'
            ]),
    ],
})
*/