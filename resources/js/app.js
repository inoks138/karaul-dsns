import './bootstrap';
import Vue from 'vue'
import router from './router';
import store from './store';
import App from './App.vue';

import vSelect from "vue-select";
import VueTimepicker from "vue2-timepicker";
import DatePicker from 'vue2-datepicker';

Vue.component("v-select", vSelect);
Vue.component("v-timepicker", VueTimepicker);
Vue.component("v-datepicker", DatePicker);

new Vue({
    router,
    store,
    render: h => h(App),
}).$mount('#app');
