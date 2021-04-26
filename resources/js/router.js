import Vue from 'vue';
import Router from 'vue-router';
import Home from './views/Home.vue';
import Categories from './views/Category.vue';


Vue.use(Router);

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home,
    },
    {
        path: '/categories',
        name: 'categories',
        component: Categories,
    }
];

const router = new Router({
    routes: routes,
    linkActiveClass: 'active'
});

export default router;