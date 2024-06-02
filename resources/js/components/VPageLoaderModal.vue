<template>
    <v-modal :show="true">
        <div class="spinner-border text-primary v-page-loader__spinner" role="status" />
    </v-modal>
</template>

<script>

import VModal from "./common/modal/VModal.vue";

export default {
    name: "VPageLoaderModal",
    components: {VModal},
}
</script>

<style scoped>
.v-page-loader__spinner {
    width: 50px;
    height: 50px;
    border-width: 6px;
}
</style>
