<template>
    <div class="d-flex justify-content-center">
        <div class="card document-card">
            <div class="card-body">
                <h3 class="text-center mb-5">Книга служби</h3>

                <label>Оберіть період, за який потріно сформувати Наряди на службу:</label>

                <v-button
                    to="/guard/start"
                    class="w-100 mt-3"
                    color="primary"
                >
                    Сформувати
                </v-button>
            </div>
        </div>
    </div>
</template>

<script>
import VButton from "../../components/common/VButton.vue";

export default {
    name: "ServiceBookPage",
    components: {VButton}
}
</script>

<style scoped>
.document-card {
    width: 400px;
    margin: 50px 0;
    padding: 15px 15px 30px 15px;
}
</style>
