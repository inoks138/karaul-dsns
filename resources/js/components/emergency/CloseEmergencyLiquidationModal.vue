<template>
    <v-modal :show="show" @closeModal="closeModal">
        <div class="modal-content" style="width: 600px;">
            <div class="modal-header">
                <h5 class="modal-title">Завершити ліквідацію НС</h5>
                <v-button @click="closeModal" class="close btn-close pe-3"/>
            </div>
            <div class="modal-body">
                <p>Підтвердіть, що НС було ліквідовано</p>
            </div>
            <div class="modal-footer">
                <v-button
                    :loading="isLoadingCloseEmergency"
                    color="danger"
                    @click="submit"
                >
                    Підтвердити
                </v-button>
                <v-button
                    color="secondary"
                    @click="closeModal"
                >
                    Закрити
                </v-button>
            </div>
        </div>
    </v-modal>
</template>

<script>
import VModal from "../common/modal/VModal.vue";
import VButton from "../common/VButton.vue";
import {closeLiquidation} from "../../api/emergencyService";

export default {
    name: "CloseEmergencyLiquidationModal",
    components: {VButton, VModal},
    props: {
        show: {
            type: Boolean,
            required: true,
        },
    },
    data() {
        return {
            isLoadingCloseEmergency: false,
        };
    },
    methods: {
        closeModal() {
            this.$emit("closeModal");
        },
        submit() {
            this.isLoadingCloseEmergency = true;

            closeLiquidation(this.$route.params.id)
                .then(() => {
                    this.closeModal();
                    this.$router.push('/');
                })
                .finally(() => {
                    this.isLoadingCloseEmergency = false;
                });
        },
    },
}
</script>

<style scoped>

</style>
