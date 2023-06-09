import './bootstrap';
import './theme';
import './browser';
import './ajax';
import './jquery-mask';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';

window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.start();
