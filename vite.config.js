import { createVuePlugin } from 'vite-plugin-vue2'
import laravel from 'laravel-vite-plugin';


export default {
  plugins: [
    createVuePlugin(),
    laravel([
            'resources/assets/js/app.js',
        ]),
  ],
}
