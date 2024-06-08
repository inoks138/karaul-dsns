<template>
    <v-modal :show="show" @closeModal="closeModal">
        <div class="modal-content" style="width: 600px;">
            <div class="modal-header">
                <h5 class="modal-title">Запросити додаткові відділення з інших підрозділів</h5>
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
                <v-button color="primary">Підтвердити</v-button>
                <v-button color="secondary" @click="closeModal">Закрити</v-button>
            </div>
        </div>
    </v-modal>
</template>

<script>
import VModal from "../common/modal/VModal.vue";
import VButton from "../common/VButton.vue";

export default {
    name: "RequestAdditionalUnitsModal",
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
        }
    },
    methods: {
        closeModal() {
            this.$emit("closeModal");
        },
    },
}
</script>

<style scoped>

</style>
