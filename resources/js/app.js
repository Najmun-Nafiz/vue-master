import Vue from 'vue';
import App from './App.vue';
import router from './router';

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap';


import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;


new Vue({
    el: '#app',
    router,
    render: h => h(App)
});
