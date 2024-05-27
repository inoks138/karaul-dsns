<template>
    <MainLayout>
        <div>Karaul DSNS Application - Home Page</div>
        <div class="btn btn-primary" @click="logout">Logout</div>
    </MainLayout>
</template>

<script>
import Navbar from "../components/Navbar.vue";
import MainLayout from "../layouts/MainLayout.vue";

export default {
    name: "HomePage",
    components: {
        MainLayout,
        Navbar,
    },
    methods: {
        logout() {
            this.$store.dispatch("logout")
                .then(() => {
                    console.log('Logout!');
                    this.$store.dispatch("resetUser");

                    this.$router.push('/login');
                });
        }
    }
}
</script>

<style scoped>

</style>
