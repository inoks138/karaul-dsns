<template>
    <MainLayout>
        <div class="d-flex justify-content-center">
            <div class="card create-units-card">
                <div class="card-body row">
                    <div class="col-9">
                        <div v-for="unit in units" class="unit__item">
                            <div class="unit__caption">
                                <div></div>
                                <label class="form-label">Відділення:</label>
                                <input
                                    :value="unit.number"
                                    :max="unitsNumberOptions"
                                    min="1"
                                    type="number"
                                    class="form-control d-inline-block ms-1"
                                    :class="{'is-invalid': unit.formErrors.number}"
                                    style="width: 54px;"
                                    @input="(e) => handleUnitNumberInput(unit.number, e)"
                                />
                                <v-button
                                    v-if="unitsNumberOptions > 1"
                                    @click="() => removeUnit(unit.number)"
                                >
                                    <i class="fa fa-close"/>
                                </v-button>
                                <div class="invalid-feedback invalid-feedback_invisible">
                                    {{ unit.formErrors.commander }}
                                </div>
                            </div>

                            <div class="unit__info">
                                <div class="form-outline">
                                    <div class="d-flex" :class="{'is-invalid': unit.formErrors.commander}">
                                        <label class="form-label mb-0 mt-1 me-1">Командир:</label>
                                        <v-select
                                            v-model="unit.commander"
                                            :options="freeCommanders"
                                            class="form-control unit__select"
                                            :class="{'is-invalid': unit.formErrors.commander}"
                                        />
                                    </div>
                                    <div class="invalid-feedback invalid-feedback_invisible unit__invalid-feedback">
                                        {{ unit.formErrors.commander }}
                                    </div>
                                </div>

                                <div class="form-outline">
                                    <div class="d-flex" :class="{'is-invalid': unit.formErrors.driver}">
                                        <label class="form-label mb-0 mt-1 me-1">Водій:</label>
                                        <v-select
                                            v-model="unit.driver"
                                            :options="freeDrivers"
                                            class="form-control unit__select"
                                            :class="{'is-invalid': unit.formErrors.driver}"
                                        />
                                    </div>
                                    <div class="invalid-feedback invalid-feedback_invisible unit__invalid-feedback">
                                        {{ unit.formErrors.driver }}
                                    </div>
                                </div>

                                <div class="form-outline">
                                    <div class="d-flex" :class="{'is-invalid': unit.formErrors.vehicle}">
                                        <label class="form-label mb-0 mt-1 me-1">Тр. засіб:</label>
                                        <v-select
                                            v-model="unit.vehicle"
                                            :options="freeVehicles"
                                            class="form-control unit__select"
                                            :class="{'is-invalid': unit.formErrors.vehicle}"
                                        />
                                    </div>
                                    <div class="is-invalid"></div>
                                    <div class="invalid-feedback invalid-feedback_invisible unit__invalid-feedback">
                                        {{ unit.formErrors.vehicle }}
                                    </div>
                                </div>

                                <div class="form-outline">
                                    <div class="d-flex" :class="{'is-invalid': unit.formErrors.firefighters}">
                                        <label class="form-label mb-0 mt-1 me-1">Бійці:</label>
                                        <v-select
                                            v-model="unit.firefighters"
                                            :options="freeFirefighters"
                                            multiple
                                            class="form-control unit__select"
                                            :closeOnSelect="false"
                                            :class="{'is-invalid': unit.formErrors.firefighters}"
                                        />
                                    </div>
                                    <div class="is-invalid"></div>
                                    <div class="invalid-feedback invalid-feedback_invisible unit__invalid-feedback">
                                        {{ unit.formErrors.firefighters }}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-3">
                        <div class="create-unit-actions">
                            <v-button
                                class="create-unit-actions__button"
                                color="success"
                                @click="addUnit"
                            >
                                Додати відділення
                            </v-button>
                            <v-button
                                class="create-unit-actions__button mt-2"
                                color="primary"
                                :loading="isLoadingSubmit"
                                @click="createUnits"
                            >
                                Зберегти
                            </v-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script>
import MainLayout from "../../layouts/MainLayout.vue";
import {
    EMPLOYEE_POSITIONS_FIREFIGHTER_ID,
    VEHICLE_TYPE_GENERAL_ID
} from "../../settings";
import {getEmployees} from "../../api/employeeService";
import {getVehicles} from "../../api/vehicleService";
import VButton from "../../components/common/VButton.vue";
import {storeUnits} from "../../api/guardService";

export default {
    name: "CreateUnitsPage",
    components: {VButton, MainLayout},
    data() {
        return {
            units: [
                {
                    number: 1,
                    commander: null,
                    driver: null,
                    vehicle: null,
                    firefighters: [],
                    formErrors: {
                        number: null,
                        commander: null,
                        driver: null,
                        vehicle: null,
                        firefighters: null,
                    },
                },
                {
                    number: 2,
                    commander: null,
                    driver: null,
                    vehicle: null,
                    firefighters: [],
                    formErrors: {
                        number: null,
                        commander: null,
                        driver: null,
                        vehicle: null,
                        firefighters: null,
                    },
                },
                {
                    number: 3,
                    commander: null,
                    driver: null,
                    vehicle: null,
                    firefighters: [],
                    formErrors: {
                        number: null,
                        commander: null,
                        driver: null,
                        vehicle: null,
                        firefighters: null,
                    },
                },
            ],

            firefighters: [],
            isLoadingFirefighters: false,
            vehicles: [],
            isLoadingVehicles: false,

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
        unitsNumberOptions() {
            return this.units.length;
        },
        selectedCommanders() {
            return this.units.filter(item => item.commander).map(item => item.commander.value);
        },
        selectedDrivers() {
            return this.units.filter(item => item.driver).map(item => item.driver.value);
        },
        selectedFirefighters() {
            return this.units.filter(item => item.firefighters)
                .map(item => item.firefighters.map(firefighter => firefighter.value))
                .reduce((arr1, arr2) => arr1.concat(arr2), []);
        },
        selectedVehicles() {
            return this.units.filter(item => item.vehicle).map(item => item.vehicle.value);
        },
        freeCommanders() {
            return this.firefighters.filter(item =>
                item.canBeCommander
                && !this.selectedCommanders.includes(item.value)
                && !this.selectedDrivers.includes(item.value)
                && !this.selectedFirefighters.includes(item.value)
            );
        },
        freeDrivers() {
            return this.firefighters.filter(item =>
                item.canBeDriver
                && !this.selectedCommanders.includes(item.value)
                && !this.selectedDrivers.includes(item.value)
                && !this.selectedFirefighters.includes(item.value)
            );
        },
        freeFirefighters() {
            return this.firefighters.filter(item =>
                !this.selectedCommanders.includes(item.value)
                && !this.selectedDrivers.includes(item.value)
                && !this.selectedFirefighters.includes(item.value)
            );
        },
        freeVehicles() {
            return this.vehicles.filter(item => !this.selectedVehicles.includes(item.value));
        },
    },
    mounted() {
        this.getFirefighters();
        this.getVehicles();
    },
    methods: {
        getFirefighters() {
            this.isLoadingFirefighters = true;

            const params = {
                firehouse_id: this.user.employee.workplace_id,
                position_id: [EMPLOYEE_POSITIONS_FIREFIGHTER_ID]
            };

            getEmployees(params)
                .then((response) => {
                    this.firefighters = response.data.map(item => ({
                        value: item.id,
                        label: item.full_name,
                        canBeCommander: item.can_be_unit_commander,
                        canBeDriver: item.can_be_unit_driver,
                    }));
                })
                .finally(() => {
                    this.isLoadingFirefighters = false;
                });
        },
        getVehicles() {
            this.isLoadingVehicles = true;

            const params = {
                firehouse_id: this.user.employee.workplace_id,
                vehicle_type_id: [VEHICLE_TYPE_GENERAL_ID],
            };

            getVehicles(params)
                .then((response) => {
                    this.vehicles = response.data.map(item => ({
                        value: item.id,
                        label: item.model.name + " | " + item.license_plate,
                    }));
                })
                .finally(() => {
                    this.isLoadingVehicles = false;
                });
        },
        addUnit() {
            this.units.push({
                number: this.unitsNumberOptions + 1,
                commander: null,
                driver: null,
                vehicle: null,
                firefighters: [],
                formErrors: {
                    number: null,
                    commander: null,
                    driver: null,
                    vehicle: null,
                    firefighters: null,
                },
            });
        },
        removeUnit(number) {
            const index = this.units.findIndex(unit => unit.number === number);

            for (let i = 0; i < this.units.length; i++) {
                if (i !== index && this.units[i].number > number) {
                    this.units[i].number--;
                }
            }

            this.units.splice(index, 1);
        },
        handleUnitNumberInput(currentUnitNumber, e) {
            const intNumber = parseInt(e.target.value);
            const unitIndex = this.units.findIndex(unit => unit.number === currentUnitNumber);

            if (!intNumber || intNumber > this.unitsNumberOptions) {
                e.target.value = currentUnitNumber;
                this.units[unitIndex].number = currentUnitNumber;

                return;
            }

            const otherUnitIndex = this.units.findIndex(unit => unit.number === intNumber);

            if (otherUnitIndex) {
                this.units[otherUnitIndex].number = currentUnitNumber;
            }

            this.units[unitIndex].number = intNumber;
        },

        validate() {
            let isValid = true;

            for (let i = 0; i < this.unitsNumberOptions; i++) {
                if (!this.units[i].commander) {
                    this.units[i].formErrors.commander = "Обов'язкове поле";
                    isValid = false;
                } else {
                    this.units[i].formErrors.commander = null;
                }

                if (!this.units[i].driver) {
                    this.units[i].formErrors.driver = "Обов'язкове поле";
                    isValid = false;
                } else {
                    this.units[i].formErrors.driver = null;
                }

                if (!this.units[i].vehicle) {
                    this.units[i].formErrors.vehicle = "Обов'язкове поле";
                    isValid = false;
                } else {
                    this.units[i].formErrors.vehicle = null;
                }

                if (this.units[i].firefighters.length === 0) {
                    this.units[i].formErrors.firefighters = "Обов'язкове поле";
                    isValid = false;
                } else {
                    this.units[i].formErrors.firefighters = null;
                }
            }

            return isValid;
        },

        createUnits() {
            if (!this.validate()) {
                return;
            }

            this.isLoadingSubmit = true;

            const payload = {
                units: this.units.map(unit => ({
                    number: unit.number,
                    commander_id: unit.commander.value,
                    driver_id: unit.driver.value,
                    vehicle_id: unit.vehicle.value,
                    firefighters: unit.firefighters.map(firefighter => firefighter.value),
                })),
            };

            storeUnits(this.guard.id, payload)
                .then((response) => {
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
.create-units-card {
    width: 950px;
    margin: 50px 0;
    padding: 30px 15px 45px 15px;
}
.unit__item {
    margin-right: 100px;
}
.unit__item + .unit__item {
    border-top: 1px solid rgba(0, 0, 0, 0.175);
    padding-top: 20px;
}
.create-unit-actions {
    display: flex;
    flex-direction: column;
    align-items: end;
}
.unit__info {
    padding-left: 40px;
}
.unit__select, .unit__invalid-feedback {
    margin-left: auto;
    width: 400px;
}
.unit__invalid-feedback {
    margin-top: 1px;
    margin-bottom: 3px;
}
.create-unit-actions__button {
    width: 180px;
}
</style>
