import './bootstrap';
import './theme';
import './browser';
import './ajax';
import './jquery-mask';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import Precognition from 'laravel-precognition-alpine';

window.Alpine = Alpine;

Alpine.plugin(focus);
Alpine.plugin(Precognition);

Alpine.start();
