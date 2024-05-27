<template>
    <div>
        <router-view />
        <v-page-loader-modal :show="getIsLoadingUserInfo"/>
    </div>
</template>

<script>
import VPageLoaderModal from "./components/VPageLoaderModal.vue";
import {mapGetters} from "vuex";

export default {
    name: "App",
    components: {VPageLoaderModal},
    computed: {
        ...mapGetters([
            "getIsLoadingUserInfo",
        ]),
    },
    mounted() {
        this.fetchUserInfo();
    },
    methods: {
        fetchUserInfo() {
            this.setIsLoadingUserInfo(true);

            this.$store.dispatch("getUserInfo")
                .then((response) => {
                    this.$store.commit("setUserInfo", response.data);
                })
                .finally(() => {
                    this.setIsLoadingUserInfo(false);
                });
        },
        setIsLoadingUserInfo(value) {
            this.$store.commit("setIsLoadingUserInfo", value);
        },
    }
}
</script>

<style scoped>

</style>
