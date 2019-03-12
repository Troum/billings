import Vue from 'vue';
import VueRouter from 'vue-router';
import store from '@/js/store.js';
import Dashboard from '@/js/components/Dashboard';
import Login from '@/js/components/Login';
import Logout from '@/js/components/Logout';
import Register from '@/js/components/Register';


Vue.use(VueRouter);

const router = new VueRouter({
   mode: 'history',
   routes: [
       {
           path: '/dashboard',
           name: 'dashboard',
           component: Dashboard,
           meta: { requiresAuth: true }
       },
       {
           path: '/login',
           name: 'login',
           component: Login
       },
       {
           path: '/logout',
           name: 'logout',
           component: Logout
       },
       {
           path: '/register',
           name: 'register',
           component: Register
       }
   ]
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(route => route.meta.requiresAuth) && !store.state.isLoggedIn) {
        next({ name: 'login' });
        return
    }
    if(to.path === '/login' && store.state.isLoggedIn) {
        next({ name: 'dashboard' });
        return
    }
    next()
});

export default router;
