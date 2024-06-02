<template>
    <MainLayout>
        <div class="d-flex justify-content-center">
            <div class="card start-guard-card">
                <div class="card-body">
                    <h3 class="text-center mb-5">Початок караулу</h3>
                    <div class="form-outline d-flex justify-content-between">
                        <div class="mt-1">
                            <label class="form-label fw-bold">Дата:</label>
                            <span>{{ getFormattedDateOfService }}</span>
                        </div>
                        <div :class="{'is-invalid': formErrors.startTime}">
                            <label class="form-label fw-bold">Час:</label>
                            <v-timepicker
                                v-model="formData.startTime"
                                class="ms-1"
                                tabindex="0"
                                :input-class="{
                                    'form-control': 'form-control',
                                    'is-invalid': formErrors.startTime,
                                }"
                            />
                            <div class="invalid-feedback invalid-feedback_invisible" style="margin-left: 40px">
                                {{ formErrors.startTime }}
                            </div>
                        </div>
                    </div>
                    <div class="form-outline" :class="{'is-invalid': formErrors.dispatcher}">
                        <label class="form-label fw-bold">Диспетчер:</label>
                        <v-select
                            v-model="formData.dispatcher"
                            :options="dispatchers"
                            :loading="isLoadingDispatchers"
                            class="form-control"
                            :class="{'is-invalid': formErrors.dispatcher}"
                        />
                        <div class="invalid-feedback invalid-feedback_invisible">
                            {{ formErrors.dispatcher }}
                        </div>

                    </div>

                    <div class="form-outline mt-1">
                        <label class="form-label fw-bold">Комментарій до попереднього караулу:</label>
                        <textarea
                            v-model="formData.prevGuardComment"
                            class="form-control"
                            rows="3"
                        />
                    </div>

                    <v-button
                        :loading="isLoadingStartGuard"
                        class="w-100 mt-4"
                        color="primary"
                        @click="startGuard"
                    >
                        Почати караул
                    </v-button>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script>
import Navbar from "../components/Navbar.vue";
import MainLayout from "../layouts/MainLayout.vue";
import VButton from "../components/common/VButton.vue";
import {getEmployees} from "../api/employeeService";
import {EMPLOYEE_POSITIONS_DISPATCHER_ID} from "../settings";
import {startGuard} from "../api/guardService";

export default {
    name: "HomePage",
    components: {
        MainLayout,
        Navbar,
        VButton,
    },
    data() {
        return {
            formData: {
                dateOfService: moment().format("YYYY-MM-DD"),
                startTime: moment().format("HH:mm"),
                dispatcher: null,
                prevGuardComment: '',
            },
            formErrors: {
                dateOfService: null,
                startTime: null,
                dispatcher: null,
            },
            dispatchers: [],
            isLoadingDispatchers: false,
            isLoadingStartGuard: false,
        };
    },
    mounted() {
        this.getDispatchers();
    },
    computed: {
        getFormattedDateOfService() {
            return moment(this.formData.dateOfService).format("DD.MM.YYYY");
        },
        user() {
            return this.$store.state.auth.user;
        },
    },
    methods: {
        validate() {
            let isValid = true;

            if (!this.formData.dateOfService) {
                this.formErrors.dateOfService = "Обов'язкове поле";
                isValid = false;
            } else {
                this.formErrors.dateOfService = null;
            }

            if (!this.formData.startTime) {
                this.formErrors.startTime = "Обов'язкове поле";
                isValid = false;
            } else {
                this.formErrors.startTime = null;
            }

            if (!this.formData.dispatcher) {
                this.formErrors.dispatcher = "Обов'язкове поле";
                isValid = false;
            } else {
                this.formErrors.dispatcher = null;
            }

            return isValid;
        },
        startGuard() {
            if (!this.validate()) {
                return;
            }

            this.isLoadingStartGuard = true;

            const payload = {
                start_time: this.formData.dateOfService + " " + this.formData.startTime + ":00",
                dispatcher_id: this.formData.dispatcher.value,
                prev_guard_comment: this.formData.prevGuardComment
            }

            startGuard(payload)
                .then((response) => {
                    console.log('guard started!');
                    console.log(response);
                })
                .finally(() => {
                    this.isLoadingStartGuard = false;
                })
        },
        getDispatchers() {
            this.isLoadingDispatchers = true;

            const params = {
                firehouse_id: this.user.employee.workplace_id,
                position_id: [EMPLOYEE_POSITIONS_DISPATCHER_ID]
            };

            getEmployees(params)
                .then((response) => {
                    this.dispatchers = response.data.map(item => ({
                        value: item.id,
                        label: item.full_name
                    }));
                })
                .finally(() => {
                    this.isLoadingDispatchers = false;
                });
        },
    }
}
</script>

<style scoped lang="scss">
.start-guard-card {
    width: 470px;
    margin: 50px 0;
    padding: 30px 30px 45px 30px;
}
</style>
