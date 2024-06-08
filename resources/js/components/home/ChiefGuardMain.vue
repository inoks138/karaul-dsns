<template>
    <div>
        <div class="alert alert-primary " role="alert" style="margin: 30px 300px;">
            Найближча подія - "Додавання стрових записок" о 06:00
        </div>

        <div class="d-flex justify-content-center">
            <div class="card home-page-card">
                <div class="card-body">
                    <h3 class="text-center mb-4">Караульна служба</h3>

                    <v-button
                        to="/guard/start"
                        class="w-100 mt-3"
                        color="primary"
                    >
                        Почати караул
                    </v-button>
                    <v-button
                        to="/guard/create-units"
                        class="w-100 mt-2"
                        color="primary"
                    >
                        Створити відділення
                    </v-button>
                    <v-button
                        to="/guard/create-vehicle-notes"
                        class="w-100 mt-2"
                        color="primary"
                    >
                        Додати стройові записки
                    </v-button>
                    <v-button
                        to="/guard/end"
                        class="w-100 mt-2"
                        color="primary"
                    >
                        Завершити караул
                    </v-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VButton from "../common/VButton.vue";

export default {
    name: "ChiefGuardMain",
    components: {VButton}
}
</script>

<style scoped>
.home-page-card {
    width: 400px;
    margin: 50px 0;
    padding: 15px 15px 30px 15px;
}
</style>
