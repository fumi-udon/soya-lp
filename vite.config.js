import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss', // ここを css から sass に変更
                'resources/js/app.js',
                'resources/sass/menu.scss', // ★ここに追加！
            ],
            refresh: true,
        }),
    ],
});

