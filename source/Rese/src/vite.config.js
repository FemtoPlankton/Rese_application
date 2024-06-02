import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // cssファイル
                'resources/css/app.css',
                'resources/css/icon-color.css',
                // jsファイル
                'resources/js/app.js',
                'resources/js/ajax-search.js'
            ],
            refresh: true,
        }),
    ],
});
