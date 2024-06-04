<template>
    <div>
        <v-page-loader-modal v-if="showPageLoader"/>
        <router-view v-else/>
    </div>
</template>

<script>
import VPageLoaderModal from "./components/VPageLoaderModal.vue";
import {mapGetters} from "vuex";
import {getCurrentGuard} from "./api/guardService";

export default {
    name: "App",
    components: {VPageLoaderModal},
    computed: {
        ...mapGetters([
            "getIsLoadedUserInfo",
            "getIsLoadedGuard",
        ]),
        isLoginRoute() {
            return this.$route.name === 'login';
        },
        showPageLoader() {
            return (!this.getIsLoadedUserInfo || !this.getIsLoadedGuard) && !this.isLoginRoute;
        }
    },
    mounted() {
        this.fetchUserInfo();
        this.fetchGuard();
    },
    methods: {
        fetchUserInfo() {
            this.$store.dispatch("getUserInfo")
                .then((response) => {
                    this.$store.commit("setUserInfo", response.data);
                })
                .catch((error) => {
                    if (error.response.status === 401) {
                        this.$store.commit("setUserToken", "")
                    }
                })
                .finally(() => {
                    this.setIsLoadedUserInfo(true);
                });
        },
        fetchGuard() {
            getCurrentGuard()
                .then((response) => {
                    this.$store.commit("setGuard", response.data);
                })
                .finally(() => {
                    this.setIsLoadedGuard(true);
                });
        },
        setIsLoadedUserInfo(value) {
            this.$store.commit("setIsLoadedUserInfo", value);
        },
        setIsLoadedGuard(value) {
            this.$store.commit("setIsLoadedGuard", value);
        },
    }
}
</script>

<style scoped>

</style>
