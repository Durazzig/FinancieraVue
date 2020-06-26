import Vue from 'vue';
import VueRouter from 'vue-router';
import store from '@/js/stores';

import Home from '@/js/components/Home';
import Login from '@/js/pages/LoginPage';
import View from '@/js/views/View';
import Clients from '@/js/pages/Clients';
import Loans from '@/js/pages/Loans';
import Payments from '@/js/pages/Payments';
import PaymentsView from '@/js/components/PaymentsView';
import User from '@/js/pages/User';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '',
            component: View,
            children: [
                {
                    path: '/',
                    name: 'home',
                    component: Home
                },
                {
                    path: '/clients',
                    name: 'clients',
                    component: Clients
                },
                {
                    path: '/payments/:id',
                    name: 'PaymentsView',
                    component: PaymentsView
                },
                {
                    path: '/loans',
                    name: 'loans',
                    component: Loans
                },
                {
                    path: '/payments',
                    name: 'payments',
                    component: Payments
                },
                {
                    path: '/user',
                    name: 'user',
                    component: User
                },
            ]
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        }
    ]
});

router.beforeEach((to, from, next) => {
    const isAuthenticated = store.state.isAuthenticated;
    if (to.name !== 'login' && !isAuthenticated) next({ name: 'login'});
    else if (to.name === 'login' && isAuthenticated) next({ name: 'home' });
    else next();
});

export default router;
