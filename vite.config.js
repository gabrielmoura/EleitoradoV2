import {defineConfig, splitVendorChunkPlugin} from 'vite';
import laravel, {refreshPaths} from 'laravel-vite-plugin';
import path from 'path';
import {VitePWA} from 'vite-plugin-pwa'
import manifestSRI from 'vite-plugin-manifest-sri';

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
        VitePWA({
            injectRegister: 'auto',
            registerType: 'autoUpdate',
            workbox: {
                globPatterns: ['**/*.{js,css,ico,png,svg,webp,eot,ttf,woff,woff2,json}'],
                sourcemap: true,

            },
            devOptions: {
                enabled: true,
                type: 'module',
            },
            manifest: {
                name: 'Eleitorado',
                short_name: 'Eleitorado',
                description: 'CRM Politico',
                theme_color: '#ffffff',
            },
        }),
        manifestSRI(),
    ],
    resolve: {
        alias: {
            '@vendor/spatie/laravel-medialibrary-pro': path.resolve(__dirname, 'vendor/spatie/laravel-medialibrary-pro/resources/js'),
        },
    },

});
