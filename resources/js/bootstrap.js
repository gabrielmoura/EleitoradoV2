/**
 * Load the TomSelect library
 */
import TomSelect from 'tom-select';
/**
 * Load the Bootstrap library
 */
import * as bootstrap from 'bootstrap';
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
import axios from 'axios';
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
import * as maplibregl from 'maplibre-gl';
window.TomSelect = TomSelect;
document.querySelectorAll('.tselect').forEach((el) => {
    new TomSelect(el, {
        allowEmptyOption: true,
        create: false,
    });
});
document.querySelectorAll('.tselect-multi').forEach((el) => {
    new TomSelect(el, {
        allowEmptyOption: true,
        create: false,
        maxItems: 50,
    });
});
document.querySelectorAll('.tselect-multi-create').forEach((el) => {
    new TomSelect(el, {
        allowEmptyOption: true,
        create: true,
        maxItems: 50,
    });
});

window.bootstrap = bootstrap;

/**
 * Define a global event bus
 */
window.addEventListener('close-modal', event => {
    const $modals = document.querySelectorAll('.modal')
    $modals.forEach(modal => {
        let currentModal = bootstrap.Modal.getInstance(modal)
        if (currentModal) currentModal.hide()
    })
})
// refresh the page
window.addEventListener('refreshBrowser', event => {
    console.log('refreshing')
    window.location.reload();
})

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

window.maplibregl = maplibregl;
