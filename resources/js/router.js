import Vue from 'vue';
import Router from 'vue-router';


//All Route List..
import Dashboard from './views/Dashboard.vue';
import Home from './views/Home.vue';
import Categories from './views/Category.vue';
import Product from './views/Product.vue';

//For Route List...
import Login from './views/auth/Login.vue';
import Register from './views/auth/Register.vue';
import ResetPassword from './views/auth/ResetPassword.vue';

import * as auth from './services/auth_service';
Vue.use(Router);

const routes = [
    {
        path: '/dashboard',
        component: Dashboard,
        children: [
            {
                path: '',
                name: 'home',
                component: Home
            },
            {
                path: '/categories',
                name: 'categories',
                component: Categories,
            },
            {
                path: '/product',
                name: 'product',
                component: Product,
            },
        ],

        beforeEnter(to, from, next) {
            if (!auth.isLoggedIn()) {
                next('/login');
            } else {
                next();
            }
        }
    },
    


    {
        path: '/register',
        name: 'register',
        component: Register
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        beforeEnter(to, from, next) {
            if (!auth.isLoggedIn()) {
                next();
            } else {
                next('/dashboard');
            }
        }
    },
    {
        path: '/resetPassword',
        name: 'resetPassword',
        component: ResetPassword
    },
];

const router = new Router({
    mode: 'history',
    routes: routes,
    linkActiveClass: 'active'
});

export default router;