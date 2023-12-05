import './bootstrap';
import './theme';
import './browser';
import './ajax';
import './jquery-mask';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import Precognition from 'laravel-precognition-alpine';
import {registerSW} from 'virtual:pwa-register'

window.Alpine = Alpine;

Alpine.plugin(focus);
Alpine.plugin(Precognition);

Alpine.start();

if ('serviceWorker' in navigator) {
    // window.addEventListener('load', () => {
        registerSW({
            immediate: true,
            onNeedRefresh() {
                // Mostrar um aviso ao usuário que ele precisa atualizar a página
            },
            onOfflineReady() {
                // Mostrar um aviso ao usuário que ele está offline
            },
            scope: '.',
        })
    // });
}


