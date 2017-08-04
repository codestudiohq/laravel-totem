import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);

export default new Router({
    mode: 'history',
    base: '/totem/',
    routes: [
        {
            path: '/',
            redirect: '/dashboard',
        },
        {
            path: '/dashboard',
            component: require('../pages/Dashboard.vue'),
        },
        {
            path: '/schedule',

        },
    ],
})
