<template>
    <MainLayout>
        <div class="d-flex justify-content-center">
            <div class="card create-units-card">
                <div class="card-body row">
                    <h3 class="text-center mb-5">Запит на ремонт транспортного засобу</h3>

                    <label class="form-label px-0">Транспортний засіб:</label>
                    <v-select
                        v-model="formData.vehicle"
                        :options="vehicles"
                        :loading="!isLoadedVehicles"
                        class="form-control"
                    />

                    <label class="form-label mt-2 px-0">Коментарій:</label>
                    <textarea
                        v-model="formData.comment"
                        class="form-control mb-2"
                        rows="3"
                    />

                    <p class="px-0 mt-4">Запит буде надіслано до ДПРЗ-1</p>

                    <v-button color="primary">
                        Надіслати
                    </v-button>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script>
import MainLayout from "../../layouts/MainLayout.vue";
import VButton from "../../components/common/VButton.vue";
import {getVehicles} from "../../api/vehicleService";

export default {
    name: "CreateVehicleRequestPage",
    components: {VButton, MainLayout},
    data(){
        return {
            formData: {
                vehicle: null,
                comment: "",
            },
            vehicles: [],
            isLoadedVehicles: false,
        };
    },
    computed: {
        user() {
            return this.$store.state.auth.user;
        },
    },
    mounted() {
        this.fetchVehicles();
    },
    methods: {
        fetchVehicles() {
            const params = {
                firehouse_id: this.user.employee.workplace_id,
            };

            getVehicles(params)
                .then((response) => {
                    this.vehicles = response.data.map(item => ({
                        value: item.id,
                        label: item.model.name + " | " + item.license_plate,
                    }));
                })
                .finally(() => {
                    this.isLoadedVehicles = true;
                });
        },
    },
}
</script>

<style scoped>
.create-units-card {
    width: 650px;
    margin: 50px 0;
    padding: 15px 15px 30px 15px;
}
</style>
