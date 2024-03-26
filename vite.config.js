import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/person.js',
                'resources/js/person-list.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        minify: true,
        cssMinify: true,
    }
});
