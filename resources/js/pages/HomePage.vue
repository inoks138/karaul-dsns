<template>
    <MainLayout>
        <div class="d-flex justify-content-center">
            <div class="card home-page-card">
                <div class="card-body">
                    <h3 class="text-center mb-5">Караульна служба</h3>

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
    </MainLayout>
</template>

<script>
import MainLayout from "../layouts/MainLayout.vue";
import VButton from "../components/common/VButton.vue";

export default {
    name: "HomePage",
    components: {
        MainLayout,
        VButton,
    },
}
</script>

<style scoped lang="scss">
.home-page-card {
    width: 400px;
    margin: 50px 0;
    padding: 15px 15px 30px 15px;
}
</style>
