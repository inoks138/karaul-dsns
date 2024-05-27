import Vue from 'vue';
import VueRouter from 'vue-router';
import HomePage from "../pages/HomePage.vue";
import LoginPage from "../pages/LoginPage.vue";


Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'home',
        component: HomePage,
    },
    {
        path: '/login',
        name: 'login',
        component: LoginPage,
    },
];

export default new VueRouter({
    mode: 'history',
    routes,
});
