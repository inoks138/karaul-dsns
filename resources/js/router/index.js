import Vue from 'vue';
import VueRouter from 'vue-router';
import HomePage from "../pages/HomePage.vue";
import LoginPage from "../pages/LoginPage.vue";
import StartGuardPage from "../pages/guard/StartGuardPage.vue";
import CreateUnitsPage from "../pages/guard/CreateUnitsPage.vue";
import CreateVehicleNotes from "../pages/guard/CreateVehicleNotes.vue";
import EndGuardPage from "../pages/guard/EndGuardPage.vue";

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
    {
        path: '/guard/start',
        name: 'start_guard',
        component: StartGuardPage,
    },
    {
        path: '/guard/create-units',
        name: 'create_units',
        component: CreateUnitsPage,
    },
    {
        path: '/guard/create-vehicle-notes',
        name: 'create_vehicle_notes',
        component: CreateVehicleNotes,
    },
    {
        path: '/guard/end',
        name: 'end_guard',
        component: EndGuardPage,
    },
];

export default new VueRouter({
    mode: 'history',
    routes,
});
