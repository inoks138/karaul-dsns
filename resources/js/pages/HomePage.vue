<template>
    <MainLayout>
        <chief-guard-main v-if="isGuardChief"/>
        <dispatcher-main v-else-if="isDispatcher"/>
        <secretary-main v-else-if="isSecretary"/>
    </MainLayout>
</template>

<script>
import MainLayout from "../layouts/MainLayout.vue";
import ChiefGuardMain from "../components/home/ChiefGuardMain.vue";
import DispatcherMain from "../components/home/DispatcherMain.vue";
import {ROLE_DISPATCHER_ID, ROLE_GUARD_CHIEF_ID, ROLE_SECRETARY_ID} from "../settings";
import SecretaryMain from "../components/home/SecretaryMain.vue";

export default {
    name: "HomePage",
    components: {
        SecretaryMain,
        MainLayout,
        ChiefGuardMain,
        DispatcherMain,
    },
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
        isSecretary() {
            return this.user.role.id === ROLE_SECRETARY_ID;
        },
    },
}
</script>

<style scoped lang="scss">
</style>
