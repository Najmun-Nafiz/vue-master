import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap';

import BootstrapVue from 'bootstrap-vue';
import Snotify, { SnotifyPosition } from 'vue-snotify';
Vue.use(BootstrapVue);


const options = {
    toast: {
      position: SnotifyPosition.rightTop,
      timeout: 10000,
    }
}
Vue.use(Snotify, options);

import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;


new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
});
