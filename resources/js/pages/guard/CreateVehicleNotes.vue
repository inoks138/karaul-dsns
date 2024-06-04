<template>
    <MainLayout>
        <div class="d-flex justify-content-center">
            <div class="card create-vehicle-notes-card">
                <div class="card-body row">
                    <h3 class="text-center mb-5">Додати стройові записки</h3>

                    <div v-if="!isLoadedVehicles" class="text-center">
                        <div class="spinner-border text-primary vehicle-loader text-center" role="status" />
                    </div>
                    <div v-else>
                        <div
                            v-for="vehicle in vehicles"
                            :key="vehicle.id"
                            class="vehicle__item row"
                        >
                            <div class="col-md-4">
                                <div class="vehicle__label">
                                    <div>
                                        Марка: {{ vehicle.name }}
                                    </div>
                                    <div>
                                        Номерний знак: {{ vehicle.licensePlate }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-outline">
                                    <div class="d-flex" :class="{'is-invalid': vehicle.formErrors.state}">
                                        <label class="form-label vehicle__form-label col-md-4">Стан:</label>
                                        <div class="col-md-8">
                                            <v-select
                                                v-model="vehicle.formData.state"
                                                :options="vehicleNoteStates"
                                                class="form-control unit__select"
                                                :class="{'is-invalid': vehicle.formErrors.state}"
                                                @option:selected="(state) => handleVehicleNoteStateChange(state, vehicle.id)"
                                                @option:deselected="(state) => handleVehicleNoteStateChange(state, vehicle.id)"
                                            />
                                            <div class="invalid-feedback invalid-feedback_invisible">
                                                {{ vehicle.formErrors.state }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="isVehicleNoteStateOther(vehicle.formData.state)" class="form-outline">
                                    <div class="d-flex" :class="{'is-invalid': vehicle.formErrors.state_comment}">
                                        <label class="form-label vehicle__form-label col-md-4">Коментар до стану:</label>
                                        <div class="col-md-8">
                                            <input
                                                v-model="vehicle.formData.state_comment"
                                                class="form-control"
                                                :class="{'is-invalid': vehicle.formErrors.state_comment}"
                                            />
                                            <div class="invalid-feedback invalid-feedback_invisible">
                                                {{ vehicle.formErrors.state_comment }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-outline">
                                    <div class="d-flex" :class="{'is-invalid': vehicle.formErrors.fuel}">
                                        <label class="form-label vehicle__form-label col-md-4">Паливо:</label>
                                        <div class="col-md-8">
                                            <input
                                                v-model="vehicle.formData.fuel"
                                                class="form-control"
                                                :class="{'is-invalid': vehicle.formErrors.fuel}"
                                            />
                                            <div class="invalid-feedback invalid-feedback_invisible">
                                                {{ vehicle.formErrors.fuel }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-outline">
                                    <div class="d-flex" :class="{'is-invalid': vehicle.formErrors.fire_extinguishing_equipment}">
                                        <label class="form-label vehicle__form-label col-md-4">Засоби пожежогасіння:</label>
                                        <div class="col-md-8">
                                            <input
                                                v-model="vehicle.formData.fire_extinguishing_equipment"
                                                class="form-control"
                                                :class="{'is-invalid': vehicle.formErrors.fire_extinguishing_equipment}"
                                            />
                                            <div class="invalid-feedback invalid-feedback_invisible">
                                                {{ vehicle.formErrors.fire_extinguishing_equipment }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <v-button
                            :loading="isLoadingSubmit"
                            color="primary"
                            class="w-100 mt-3"
                            @click="createVehicleNotes"
                        >
                            Додати стройові записки
                        </v-button>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script>
import {getVehicles} from "../../api/vehicleService";
import MainLayout from "../../layouts/MainLayout.vue";
import {getVehicleNoteStates} from "../../api/vehicleNoteService";
import {VEHICLE_NOTE_STATE_OTHER} from "../../settings";
import {createVehicleNotes} from "../../api/guardService";
import VButton from "../../components/common/VButton.vue";

export default {
    name: "CreateVehicleNotes",
    components: {VButton, MainLayout},
    data() {
        return {
            vehicles: [],
            isLoadedVehicles: false,

            vehicleNoteStates: [],
            isLoadedVehicleNoteStates: false,

            isLoadingSubmit: false,
        };
    },
    computed: {
        user() {
            return this.$store.state.auth.user;
        },
        guard() {
            return this.$store.state.auth.guard;
        },
    },
    mounted() {
        this.getVehicles();
        this.getVehicleNoteStates();
    },
    methods: {
        getVehicles() {
            const params = {
                firehouse_id: this.user.employee.workplace_id,
            };

            getVehicles(params)
                .then((response) => {
                    this.vehicles = response.data.map(item => ({
                        id: item.id,
                        name: item.model.name,
                        licensePlate: item.license_plate,
                        formData: {
                            state: null,
                            state_comment: "",
                            fuel: "",
                            fire_extinguishing_equipment: "",
                        },
                        formErrors: {
                            state: null,
                            state_comment: null,
                            fuel: null,
                            fire_extinguishing_equipment: null,
                        },
                    }));
                })
                .finally(() => {
                    this.isLoadedVehicles = true;
                });
        },
        getVehicleNoteStates() {
            getVehicleNoteStates()
                .then((response) => {
                    this.vehicleNoteStates = response.data.map(item => ({
                        value: item.id,
                        label: item.name,
                    }));
                })
                .finally(() => {
                    this.isLoadedVehicleNoteStates = true;
                });
        },
        isVehicleNoteStateOther(state) {
            const value = state?.value || state;

            return value === VEHICLE_NOTE_STATE_OTHER;
        },
        handleVehicleNoteStateChange(state, vehicleId) {
            if (this.isVehicleNoteStateOther(state)) {
                const index = this.vehicles.findIndex(item => item.id === vehicleId);

                if (index !== -1) {
                    this.vehicles[index].formData.state_comment = "";
                    this.vehicles[index].formErrors.state_comment = null;
                }
            }
        },
        validate() {
            let isValid = true;

            for (let i = 0; i < this.vehicles.length; i++) {
                if (!this.vehicles[i].formData.state) {
                    console.log('Not valid state');
                    this.vehicles[i].formErrors.state = "Обов'язкове поле";
                    isValid = false;
                } else {
                    this.vehicles[i].formErrors.state = null;
                }

                if (
                    this.isVehicleNoteStateOther(this.vehicles[i].formData.state)
                    && !this.vehicles[i].formData.state_comment
                ) {
                    this.vehicles[i].formErrors.state_comment = "Обов'язкове поле";
                    isValid = false;
                } else {
                    this.vehicles[i].formErrors.state_comment = null;
                }

                if (!this.vehicles[i].formData.fuel) {
                    this.vehicles[i].formErrors.fuel = "Обов'язкове поле";
                    isValid = false;
                } else {
                    this.vehicles[i].formErrors.fuel = null;
                }

                if (!this.vehicles[i].formData.fire_extinguishing_equipment) {
                    this.vehicles[i].formErrors.fire_extinguishing_equipment = "Обов'язкове поле";
                    isValid = false;
                } else {
                    this.vehicles[i].formErrors.fire_extinguishing_equipment = null;
                }
            }

            return isValid;
        },

        createVehicleNotes() {
            if (!this.validate()) {
                return;
            }

            this.isLoadingSubmit = true;

            const payload = {
                vehicles: this.vehicles.map((vehicle) => ({
                    vehicle_id: vehicle.id,
                    state_id: vehicle.formData.state.value,
                    state_comment: vehicle.formData.state_comment,
                    fuel: vehicle.formData.fuel,
                    fire_extinguishing_equipment: vehicle.formData.fire_extinguishing_equipment,
                })),
            };

            createVehicleNotes(this.guard.id, payload)
                .then(response => {
                    console.log(response);
                })
                .finally(() => {
                    this.isLoadingSubmit = false;
                });
        }
    },
}
</script>

<style scoped>
.create-vehicle-notes-card {
    width: 950px;
    margin: 50px 0;
    padding: 30px 15px 45px 15px;
}
.vehicle-loader {
    width: 50px;
    height: 50px;
    border-width: 6px;
}
.vehicle__item + .vehicle__item  {
    border-top: 1px solid rgba(0, 0, 0, 0.175);
    padding-top: 20px;
}
.vehicle__label {
    margin-top: 4px;
}
.vehicle__form-label {
    margin-top: 3px;
    padding-right: 15px;
    text-align: right;
}
</style>
