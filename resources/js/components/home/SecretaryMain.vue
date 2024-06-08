<template>
    <div class="d-flex justify-content-center">
        <div class="card home-page-card">
            <div class="card-body">
                <h3 class="text-center mb-5">Документи</h3>

                <v-button
                    to="/documents/service-book"
                    class="w-100 mt-3"
                    color="primary"
                >
                    Книга служби
                </v-button>
                <v-button
                    to="/documents/vehicle-log-book"
                    class="w-100 mt-2"
                    color="primary"
                >
                    Журнал стройових записок
                </v-button>
                <v-button
                    to="/documents/dispatcher-log-book"
                    class="w-100 mt-2"
                    color="primary"
                >
                    Журнал пукнту зв'язку
                </v-button>
            </div>
        </div>
    </div>
</template>

<script>
import VButton from "../common/VButton.vue";

export default {
    name: "SecretaryMain",
    components: {VButton}
}
</script>

<style scoped>
.home-page-card {
    width: 450px;
    margin: 50px 0;
    padding: 15px 15px 30px 15px;
}
</style>
