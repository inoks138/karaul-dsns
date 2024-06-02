<template>
    <div>
        <Navbar/>
        <div class="main-layout__content-wrap bg-light">
            <slot />
        </div>
    </div>
</template>

<script>
import Navbar from "../components/Navbar.vue";

export default {
    name: "MainLayout",
    components: {Navbar}
}
</script>

<style scoped>
.main-layout__content-wrap {
    min-height: 100vh;
}
</style>
