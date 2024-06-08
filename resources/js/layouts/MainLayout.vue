<template>
    <div>
        <Navbar/>
        <div class="main-layout__content-wrap bg-light">
            <slot v-if="isGuardChief || isLoginRoute"/>
            <dispatcher-view v-if="isDispatcher">
                <slot/>
            </dispatcher-view>
        </div>
    </div>
</template>

<script>
import Navbar from "../components/Navbar.vue";
import {ROLE_DISPATCHER_ID, ROLE_GUARD_CHIEF_ID} from "../settings";
import DispatcherView from "../components/home/DispatcherView.vue";

export default {
    name: "MainLayout",
    components: {DispatcherView, Navbar},
    computed: {
        user() {
            return this.$store.state.auth.user;
        },
        isGuardChief() {
            return this.user.role.id === ROLE_GUARD_CHIEF_ID;
        },
        isDispatcher() {
            return this.user.role.id === ROLE_DISPATCHER_ID;
        },
        isLoginRoute() {
            return this.$route.name === 'login';
        },
    },
}
</script>

<style scoped>
.main-layout__content-wrap {
    min-height: 89.9vh;
}
</style>
