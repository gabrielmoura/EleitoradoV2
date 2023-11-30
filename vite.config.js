import {defineConfig, splitVendorChunkPlugin} from 'vite';
import laravel, {refreshPaths} from 'laravel-vite-plugin';
import path from 'path';

/**
 * @type {import('vite').UserConfig}
 */
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss',
                'resources/scss/tail.scss',
                'resources/js/app.js',
            ],
            refresh: [
                ...refreshPaths,
                'app/Http/Livewire/**',
            ],
        }),
        splitVendorChunkPlugin(),
    ],
    resolve: {
        alias: {
            '@vendor/spatie/laravel-medialibrary-pro': path.resolve(__dirname, 'vendor/spatie/laravel-medialibrary-pro/resources/js'),
        },
    },

});
