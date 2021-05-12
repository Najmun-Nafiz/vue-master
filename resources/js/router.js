import Vue from 'vue';
import Router from 'vue-router';


//All Route List..
import Dashboard from './views/Dashboard.vue';
import Home from './views/Home.vue';
import Categories from './views/Category.vue';
import Product from './views/Product.vue';

//For Route List...
import Register from './views/auth/Register.vue';


Vue.use(Router);

const routes = [
    {
        path: '/dashboard',
        name: 'dashboard',
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
        ]
    },
    


    {
        path: '/register',
        name: 'register',
        component: Register
    },
];

const router = new Router({
    mode: 'history',
    routes: routes,
    linkActiveClass: 'active'
});

export default router;