<template>
    <v-modal :show="show" @closeModal="closeModal">
        <div class="modal-content" style="width: 600px;">
            <div class="modal-header">
                <h5 class="modal-title">Передати запит іншим підрозділам</h5>
                <v-button @click="closeModal" class="close btn-close pe-3"/>
            </div>
            <div class="modal-body">
                <p>Додайте коментар:</p>
                <textarea
                    v-model="comment"
                    class="form-control"
                    rows="3"
                />
            </div>
            <div class="modal-footer">
                <v-button
                    :loading="isLoadingDeclineEmergency"
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
import {declineLiquidation} from "../../api/emergencyService";

export default {
    name: "EmergencyRequestForwardModal",
    components: {VButton, VModal},
    props: {
        show: {
            type: Boolean,
            required: true,
        },
    },
    data() {
        return {
            comment: "",
            isLoadingDeclineEmergency: false,
        }
    },
    methods: {
        closeModal() {
            this.$emit("closeModal");
        },
        submit() {
            this.isLoadingDeclineEmergency = true;

            const payload = {
                comment: this.comment,
            };

            declineLiquidation(this.$route.params.id, payload)
                .then(() => {
                    this.$emit('setLiquidationRequestIsAccepted', false);
                    this.closeModal();
                })
                .finally(() => {
                    this.isLoadingDeclineEmergency = false;
                });
        },
    },
}
</script>

<style scoped>

</style>
