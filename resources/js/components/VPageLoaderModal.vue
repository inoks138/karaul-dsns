<template>
    <v-modal :show="show">
        <div class="spinner-border text-primary v-page-loader__spinner" role="status" />
    </v-modal>
</template>

<script>

import VModal from "./common/modal/VModal.vue";

export default {
    name: "VPageLoaderModal",
    props: {
        show: {
            type: Boolean,
            required: true,
        },
    },
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
