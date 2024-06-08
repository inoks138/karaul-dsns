import Vue from 'vue';
import VueRouter from 'vue-router';
import HomePage from "../pages/HomePage.vue";
import LoginPage from "../pages/LoginPage.vue";
import StartGuardPage from "../pages/guard/StartGuardPage.vue";
import CreateUnitsPage from "../pages/guard/CreateUnitsPage.vue";
import CreateVehicleNotes from "../pages/guard/CreateVehicleNotes.vue";
import EndGuardPage from "../pages/guard/EndGuardPage.vue";
import EmergencyDetailPage from "../pages/emergency/EmergencyDetailPage.vue";
import ServiceBookPage from "../pages/documents/ServiceBookPage.vue";
import DispatcherLogBookPage from "../pages/documents/DispatcherLogBookPage.vue";
import VehicleLogBookPage from "../pages/documents/VehicleLogBookPage.vue";
import CreateVehicleRequestPage from "../pages/guard/CreateVehicleRequestPage.vue";

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
        path: '/guard/create-vehicle-repair-request',
        name: 'create_vehicle_repair_request',
        component: CreateVehicleRequestPage,
    },
    {
        path: '/guard/end',
        name: 'end_guard',
        component: EndGuardPage,
    },
    {
        path: '/emergencies/:id',
        name: 'emergency_detail',
        component: EmergencyDetailPage,
    },
    {
        path: '/documents/service-book',
        name: 'service_book',
        component: ServiceBookPage,
    },
    {
        path: '/documents/vehicle-log-book',
        name: 'vehicle_log_book',
        component: VehicleLogBookPage,
    },
    {
        path: '/documents/dispatcher-log-book',
        name: 'dispatcher_log_book',
        component: DispatcherLogBookPage,
    },
];

export default new VueRouter({
    mode: 'history',
    routes,
});
