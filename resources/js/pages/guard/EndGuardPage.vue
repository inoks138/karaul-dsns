<template>
    <MainLayout>
        <div class="d-flex justify-content-center">
            <div class="card end-guard-card">
                <div class="card-body">
                    <h3 class="text-center mb-5">Завершення караулу</h3>

                    <div v-if="!isLoadedData" class="text-center">
                        <div class="spinner-border text-primary end-guard-data-loader text-center" role="status" />
                    </div>
                    <div v-else>
                        <div>
                            <div class="d-flex mb-2">
                                <div class="col-md-5">
                                    <div class="d-flex">
                                        <div class="mt-5px">Початок караулу: {{ getFormattedDate(readonlyData.startDate) }}</div>
                                        <v-timepicker
                                            v-model="readonlyData.startTime"
                                            class="shrunk ms-2"
                                            :input-class="{
                                                'form-control': 'form-control',
                                            }"
                                            disabled
                                        />
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="d-flex">
                                        <div class="mt-5px">Завершення караулу: {{ getFormattedDate(readonlyData.endDate) }}</div>
                                        <v-timepicker
                                            v-model="formData.endTime"
                                            class="shrunk ms-2"
                                            :input-class="{
                                            'form-control': 'form-control',
                                        }"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div>Начальник караулу: {{ readonlyData.chiefName }}</div>
                            <div>Диспетчер: {{ readonlyData.dispatcherName }}</div>
                        </div>


                        <div class="mt-3">
                            <h6>1. Склад караулу</h6>

                            <div class="guard-line-up d-flex flex-wrap column-gap-4 row-gap-2">
                                <div>
                                    <label class="form-label">За списком</label>
                                    <input
                                        v-model="readonlyData.employeesCount"
                                        min="0"
                                        type="number"
                                        class="form-control form-control__end-guard_number"
                                        disabled
                                    />
                                </div>
                                <div>
                                    <label class="form-label">У відпустці</label>
                                    <input
                                        v-model="formData.vacationEmployeesCount"
                                        min="0"
                                        type="number"
                                        class="form-control form-control__end-guard_number"
                                        :class="{'is-invalid': formErrors.vacationEmployeesCount}"
                                    />
                                    <div class="invalid-feedback">
                                        {{ formErrors.vacationEmployeesCount }}
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label">У відрядженні</label>
                                    <input
                                        v-model="formData.businessTripEmployeesCount"
                                        min="0"
                                        type="number"
                                        class="form-control form-control__end-guard_number"
                                        :class="{'is-invalid': formErrors.businessTripEmployeesCount}"
                                    />
                                    <div class="invalid-feedback">
                                        {{ formErrors.businessTripEmployeesCount }}
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label">Відсутні через хворобу</label>
                                    <input
                                        v-model="formData.sickEmployeesCount"
                                        min="0"
                                        type="number"
                                        class="form-control form-control__end-guard_number"
                                        :class="{'is-invalid': formErrors.sickEmployeesCount}"
                                    />
                                    <div class="invalid-feedback">
                                        {{ formErrors.sickEmployeesCount }}
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label">У наявності</label>
                                    <input
                                        v-model="formData.stockEmployeesCount"
                                        min="0"
                                        type="number"
                                        class="form-control form-control__end-guard_number"
                                        :class="{'is-invalid': formErrors.stockEmployeesCount}"
                                    />
                                    <div class="invalid-feedback">
                                        {{ formErrors.stockEmployeesCount }}
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label">В оперативному розрахунку</label>
                                    <input
                                        v-model="readonlyData.operationalCalculationEmployeesCount"
                                        min="0"
                                        type="number"
                                        class="form-control form-control__end-guard_number"
                                        disabled
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="d-flex justify-content-between mb-2">
                                <h6 class="mt-2">2. Внутрішній наряд</h6>
                                <v-button color="success" @click="addInternalService">
                                    Додати внутрішній наряд
                                </v-button>
                            </div>

                            <div v-if="formData.internalServices.length">
                                <div
                                    v-for="(service, index) in formData.internalServices"
                                    :key="index"
                                    class="d-flex"
                                >
                                    <div class="form-outline col-md-4 pe-2">
                                        <div :class="{'is-invalid': service.formErrors.type}">
                                            <label class="form-label mb-0 mt-1 me-1">Вид наряду:</label>
                                            <v-select
                                                v-model="service.type"
                                                :options="internal_service_types"
                                                class="form-control unit__select"
                                                :class="{'is-invalid': service.formErrors.type}"
                                            />
                                        </div>
                                        <div class="invalid-feedback">
                                            {{ service.formErrors.type }}
                                        </div>
                                    </div>
                                    <div class="form-outline col-md-4 pe-2">
                                        <div :class="{'is-invalid': service.formErrors.employee}">
                                            <label class="form-label mb-0 mt-1 me-1">Працівник:</label>
                                            <v-select
                                                v-model="service.employee"
                                                :options="employees"
                                                class="form-control unit__select"
                                                :class="{'is-invalid': service.formErrors.employee}"
                                            />
                                        </div>
                                        <div class="invalid-feedback">
                                            {{ service.formErrors.employee }}
                                        </div>
                                    </div>
                                    <div class="form-outline col-md-3 pe-1">
                                        <div :class="{'is-invalid': service.formErrors.startDate}">
                                            <label class="form-label mb-0 mt-1 me-1">Час заступання:</label>
                                            <div class="d-flex">
                                                <v-datepicker
                                                    v-model="service.startDate"
                                                    format="DD.MM.YYYY"
                                                    :input-class="{
                                                    'form-control': 'form-control',
                                                    'is-invalid': service.formErrors.startDate
                                                }"
                                                />
                                                <v-timepicker
                                                    v-model="service.startTime"
                                                    class="shrunk ms-1"
                                                    :input-class="{
                                                    'form-control': 'form-control',
                                                }"
                                                />
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">
                                            {{ service.formErrors.employee }}
                                        </div>
                                    </div>
                                    <div class="col-md-1" style="padding-top: 28px;">
                                        <v-button
                                            @click="() => removeInternalService(index)"
                                        >
                                            <i class="fa fa-close"/>
                                        </v-button>
                                    </div>
                                </div>
                            </div>
                            <div
                                v-else
                                class="end-guard__list_no-data"
                            >
                                Немає внутрішніх нарядів
                            </div>
                        </div>

                        <div class="mt-3">
                            <h6>3. Результати перевірки організації несення служби, оцінка дій чергового караулу</h6>

                            <textarea
                                v-model="formData.serviceInspection"
                                class="form-control"
                                rows="3"
                            />
                        </div>

                        <div class="mt-3">
                            <h6>4. Несправності джерел протипожежного водопостачання, проїздів, доріг, засобів зв’язку в районі виїзду підрозділу</h6>

                            <textarea
                                v-model="formData.malfunctions"
                                class="form-control"
                                rows="3"
                            />
                        </div>

                        <div class="mt-3">
                            <div class="d-flex justify-content-between mb-2">
                                <h6 class="mt-2">5. Робота рукавів</h6>
                                <v-button color="success" @click="addFireHoseUsage">
                                    Додати роботу рукавів
                                </v-button>
                            </div>

                            <div v-if="formData.fireHoseUsages.length">
                                <div
                                    v-for="(item, index) in formData.fireHoseUsages"
                                    :key="index"
                                    class="d-flex"
                                >
                                    <div class="form-outline col-md-3 pe-2">
                                        <div :class="{'is-invalid': item.formErrors.diameter}">
                                            <label class="form-label mb-0 mt-1 me-1">Диаметр:</label>
                                            <input
                                                v-model="item.diameter"
                                                type="number"
                                                step ="0.01"
                                                class="form-control"
                                                :class="{'is-invalid': item.formErrors.diameter}"
                                            >
                                        </div>
                                        <div class="invalid-feedback">
                                            {{ item.formErrors.diameter }}
                                        </div>
                                    </div>
                                    <div class="form-outline col-md-5 pe-2">
                                        <div :class="{'is-invalid': item.formErrors.hoseNumber}">
                                            <label class="form-label mb-0 mt-1 me-1">Номери рукавів:</label>
                                            <input
                                                v-model="item.hoseNumber"
                                                type="text"
                                                class="form-control"
                                                :class="{'is-invalid': item.formErrors.hoseNumber}"
                                            >
                                        </div>
                                        <div class="invalid-feedback">
                                            {{ item.formErrors.hoseNumber }}
                                        </div>
                                    </div>
                                    <div class="form-outline pe-1">
                                        <div :class="{'is-invalid': item.formErrors.startTime}">
                                            <label class="form-label mb-0 mt-1 me-1">Час роботи:</label>
                                            <div class="d-flex">
                                                <v-timepicker
                                                    v-model="item.startTime"
                                                    format="HH:mm:ss"
                                                    class="shrunk-md ms-1"
                                                    :input-class="{
                                                        'form-control': 'form-control',
                                                    }"
                                                />
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">
                                            {{ item.formErrors.startTime }}
                                        </div>
                                    </div>
                                    <div style="padding-top: 28px;">
                                        <v-button
                                            @click="() => removeFireHoseUsage(index)"
                                        >
                                            <i class="fa fa-close"/>
                                        </v-button>
                                    </div>
                                </div>
                            </div>
                            <div
                                v-else
                                class="end-guard__list_no-data"
                            >
                                Немає роботи рукавів
                            </div>
                        </div>

                        <v-button
                            :loading="isLoadingSubmit"
                            color="primary"
                            class="w-100"
                            style="margin-top: 35px;"
                            @click="endGuard"
                        >
                            Завершити караул
                        </v-button>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script>
import MainLayout from "../../layouts/MainLayout.vue";
import {endGuard, getEndGuardData, getInternalServiceTypes} from "../../api/guardService";
import {EMPLOYEE_POSITIONS_FIREFIGHTER_ID} from "../../settings";
import {getEmployees} from "../../api/employeeService";
import VButton from "../../components/common/VButton.vue";

export default {
    name: "EndGuardPage",
    components: {VButton, MainLayout},
    data() {
        return {
            readonlyData: {
                startDate: null,
                startTime: null,
                endDate: moment().format("YYYY-MM-DD"),

                chiefName: null,
                dispatcherName: null,

                employeesCount: null,
                operationalCalculationEmployeesCount: null,
            },

            formData: {
                endTime: moment().format("HH:mm"),

                vacationEmployeesCount: null,
                businessTripEmployeesCount: null,
                sickEmployeesCount: null,
                stockEmployeesCount: null,

                internalServices: [],
                serviceInspection: "",
                malfunctions: "",

                fireHoseUsages: [],
            },

            formErrors: {
                endTime: null,
                vacationEmployeesCount: null,
                businessTripEmployeesCount: null,
                sickEmployeesCount: null,
                stockEmployeesCount: null,
                internalServices: null,
                serviceInspection: null,
                malfunctions: null,
                fireHoseUsages: null,
            },

            internal_service_types: [],
            isLoadedInternalServiceTypes: false,

            employees: [],
            isLoadedEmployees: false,

            isLoadedEndGuardData: false,
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
        isLoadedData() {
            return this.isLoadedInternalServiceTypes && this.isLoadedEndGuardData && this.isLoadedEmployees;
        },
    },
    mounted() {
        this.getInternalServiceTypes();
        this.getEndGuardData();
        this.getEmployees();
    },
    methods: {
        getFormattedDate(date) {
            return moment(date).format("DD.MM.YYYY");
        },
        getInternalServiceTypes() {
            getInternalServiceTypes()
                .then((response) => {
                    this.internal_service_types = response.data.map(item => ({
                        value: item.id,
                        label: item.name,
                    }));
                })
                .finally(() => {
                    this.isLoadedInternalServiceTypes = true;
                });
        },
        getEmployees() {
            const params = {
                firehouse_id: this.user.employee.workplace_id,
            };

            getEmployees(params)
                .then((response) => {
                    this.employees = response.data.map(item => ({
                        value: item.id,
                        label: item.full_name,
                    }));
                })
                .finally(() => {
                    this.isLoadedEmployees = true;
                });
        },
        getEndGuardData() {
            getEndGuardData(this.guard.id)
                .then((response) => {
                    const data = response.data;
                    const startTime = moment(data.guard.start_time);

                    this.readonlyData.startTime = startTime.format("HH:mm");
                    this.readonlyData.startDate = startTime.format("YYYY-MM-DD");
                    this.readonlyData.chiefName = data.guard.chief.full_name;
                    this.readonlyData.dispatcherName = data.guard.dispatcher.full_name;

                    this.readonlyData.employeesCount = data.employees_count;
                    this.readonlyData.operationalCalculationEmployeesCount = data.operational_calculation_employees_count;
                })
                .finally(() => {
                    this.isLoadedEndGuardData = true;
                });
        },

        addInternalService() {
            this.formData.internalServices.push({
                type: null,
                employee: null,
                startDate: new Date(this.readonlyData.startDate),
                startTime: null,
                formErrors: {
                    type: null,
                    employee: null,
                    startDate: null,
                    startTime: null,
                },
            });
        },

        removeInternalService(index) {
            this.formData.internalServices.splice(index, 1);
        },

        addFireHoseUsage() {
            this.formData.fireHoseUsages.push({
                diameter: null,
                hoseNumber: null,
                workTime: null,
                formErrors: {
                    diameter: null,
                    hoseNumber: null,
                    workTime: null,
                },
            });
        },

        removeFireHoseUsage(index) {
            this.formData.fireHoseUsages.splice(index, 1);
        },

        validate() {
            let isValid = true;

            return isValid;
        },
        endGuard() {
            if (!this.validate()) {
                return;
            }

            this.isLoadingSubmit = true;

            const payload = {
                end_time: this.formData.endDate + " " + this.formData.endTime + ":00",
                vacation_employees_count: this.formData.vacationEmployeesCount,
                business_trip_employees_count: this.formData.businessTripEmployeesCount,
                sick_employees_count: this.formData.sickEmployeesCount,
                stock_employees_count: this.formData.stockEmployeesCount,

                internal_services: [],
                serviceInspection: "",
                malfunctions: "",

                fire_hose_usages: [],
            };

            endGuard(this.guard.id, payload)
                .then(() => {

                })
                .finally(() => {
                    this.isLoadingSubmit = false;
                });
        },
    },
}
</script>

<style lang="scss" scoped>
.end-guard-card {
    width: 950px;
    margin: 50px 0;
    padding: 30px 15px 45px 15px;
}
.end-guard-data-loader {
    width: 50px;
    height: 50px;
    border-width: 6px;
}
.form-control__end-guard_number {
    width: 64px;
    display: inline-block;
    margin-left: 5px;
}
.end-guard__list_no-data {
    padding: 20px 0;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    background-color: #f6f6f6;
    text-align: center;
}
</style>
