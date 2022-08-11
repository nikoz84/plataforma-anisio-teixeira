import vue from '@vitejs/plugin-vue2'
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';


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
        ]),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve:{
        alias:{
            '@': __dirname + '/resources/js',
        },
    },
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