import Vue from 'vue';
import App from './App.vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap';

import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

new Vue({
    el: '#app',
    render: h => h(App)
});
