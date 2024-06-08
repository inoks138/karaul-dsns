<template>
    <MainLayout>
        <div class="card emergency-detail-card">
            <div class="card-body">
                <h3 class="text-center mb-5">Надзвичайна ситуація</h3>

                <div v-if="!isLoadedEmergency">
                    Loading...
                </div>
                <div v-else>
                    <div class="emergency__info row">
                        <div class="col-8">
                            <div>Вид НС: {{ emergency.type.name }}</div>
                            <div>Час виклику: {{ getFormattedDateTime(emergency.reported_at) }}</div>
                            <div>Адреса: {{ emergency.address }}</div>
                            <div>Підрозділ створивший запит: {{ emergency.workplace_name }}</div>

                            <label class="form-label mt-2 mb-1">Інформація про обстановку на місці події:</label>
                            <textarea
                                v-model="emergency.comment"
                                class="form-control"
                                rows="3"
                                disabled
                            />
                        </div>
                        <div class="col-4">
                            <v-button
                                v-if="!isAcceptedEmergencyLiquidation"
                                :loading="isLoadingAcceptEmergency"
                                color="primary"
                                class="w-100"
                                @click="acceptLiquidation"
                            >
                                Почати ліквідацію
                            </v-button>
                            <v-button
                                v-if="!isReadEmergencyLiquidation && !isLoadingAcceptEmergency"
                                color="danger"
                                class="w-100 mt-2"
                                @click="openForwardEmergencyRequestModal"
                            >
                                Передати запит іншим підрозділам
                            </v-button>
                            <v-button
                                v-if="isAcceptedEmergencyLiquidation"
                                color="primary"
                                class="w-100"
                                @click="openRequestAdditionalUnitsModal"
                            >
                                Запросити додаткові відділення з інших підрозділів
                            </v-button>
                            <v-button
                                v-if="isAcceptedEmergencyLiquidation"
                                color="danger"
                                class="w-100 mt-2"
                                @click="openCloseEmergencyLiquidationModal"
                            >
                                Завершити ліквідацію
                            </v-button>
                        </div>
                    </div>

                    <div v-if="isAcceptedEmergencyLiquidation" class="mt-5">
                        <h3 class="text-center mb-4">
                            Ліквідація
                        </h3>

                        <div class="liquidation__tabs">
                            <div
                                v-for="liquidationTab in liquidationTabs"
                                :key="liquidationTab.value"
                                class="liquidation__tab"
                                :class="{selected: selectedLiquidationTab === liquidationTab.value}"
                                tabindex="0"
                                @click="() => setSelectedLiquidationTab(liquidationTab.value)"
                            >
                                {{ liquidationTab.label }}
                            </div>
                        </div>

                        <div class="liquidation__tab-content">
                            <div v-if="selectedLiquidationTab === 'unit'">
                                <div class="d-flex align-items-center justify-content-between mb-2 mt-2">
                                    <div>Задіяно відділень: {{ liquidations.length }} (збережено {{ unitsUsedCount }})</div>
                                    <div class="d-flex">
                                        <v-button
                                            :disabled="isLoadingSyncLiquidatons"
                                            color="success"
                                            @click="addLiquidationUnit"
                                        >
                                            Додати відділення
                                        </v-button>
                                        <v-button
                                            :loading="isLoadingSyncLiquidatons"
                                            color="primary ms-2"
                                            @click="saveLiquidationUnits"
                                        >
                                            Збергти
                                        </v-button>
                                    </div>
                                </div>

                                <div v-for="(liquidation, key) in liquidations" class="liquidation__unit">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-outline">
                                                <label class="form-label form-select__label">Відділення:</label>
                                                <v-select
                                                    v-model="liquidation.unit"
                                                    :options="freeUnits"
                                                    class="form-control form-select"
                                                />
                                            </div>
                                            <div class="form-outline">
                                                <label class="form-label form-select__label">Транспортний засіб:</label>
                                                <v-select
                                                    v-model="liquidation.vehicle"
                                                    :options="vehicles"
                                                    class="form-control form-select"
                                                />
                                            </div>

                                            <v-button
                                                v-if="!liquidation.id"
                                                color="danger"
                                                style="margin-top: 93px; width: 350px"
                                                @click="() => removeLiquidationUnit(key)"
                                            >
                                                Видалити
                                            </v-button>
                                        </div>
                                        <div class="col-6">
                                            <div class="liquidation-form-field__item">
                                                <div class="liquidation-time__label">Час виїзду:</div>
                                                <div class="d-flex ms-2">
                                                    <v-datepicker
                                                        v-model="liquidation.departuredDate"
                                                        format="DD.MM.YYYY"
                                                        input-class="form-control"
                                                    />
                                                    <v-timepicker
                                                        v-model="liquidation.departuredAt"
                                                        class="shrunk ms-1"
                                                        input-class="form-control"
                                                    />
                                                </div>
                                            </div>
                                            <div class="liquidation-form-field__item">
                                                <div class="liquidation-time__label">Час прибуття до місця:</div>
                                                <div class="d-flex ms-2">
                                                    <v-datepicker
                                                        v-model="liquidation.arrivedDate"
                                                        format="DD.MM.YYYY"
                                                        input-class="form-control"
                                                    />
                                                    <v-timepicker
                                                        v-model="liquidation.arrivedAt"
                                                        class="shrunk ms-1"
                                                        input-class="form-control"
                                                    />
                                                </div>
                                            </div>
                                            <div class="liquidation-form-field__item">
                                                <div class="liquidation-time__label">Час подачі першого ствола на гасіння:</div>
                                                <div class="d-flex ms-2">
                                                    <v-datepicker
                                                        v-model="liquidation.firstBarrelDeliveredDate"
                                                        format="DD.MM.YYYY"
                                                        input-class="form-control"
                                                    />
                                                    <v-timepicker
                                                        v-model="liquidation.firstBarrelDeliveredAt"
                                                        class="shrunk ms-1"
                                                        input-class="form-control"
                                                    />
                                                </div>
                                            </div>
                                            <div class="liquidation-form-field__item">
                                                <div class="liquidation-time__label">Час локалізації:</div>
                                                <div class="d-flex ms-2">
                                                    <v-datepicker
                                                        v-model="liquidation.localizedDate"
                                                        format="DD.MM.YYYY"
                                                        input-class="form-control"
                                                    />
                                                    <v-timepicker
                                                        v-model="liquidation.localizedAt"
                                                        class="shrunk ms-1"
                                                        input-class="form-control"
                                                    />
                                                </div>
                                            </div>
                                            <div class="liquidation-form-field__item">
                                                <div class="liquidation-time__label">Час ліквідації:</div>
                                                <div class="d-flex ms-2">
                                                    <v-datepicker
                                                        v-model="liquidation.liquidatedDate"
                                                        format="DD.MM.YYYY"
                                                        input-class="form-control"
                                                    />
                                                    <v-timepicker
                                                        v-model="liquidation.liquidatedAt"
                                                        class="shrunk ms-1"
                                                        input-class="form-control"
                                                    />
                                                </div>
                                            </div>
                                            <div class="liquidation-form-field__item">
                                                <div class="liquidation-time__label">Час повернення до розташування:</div>
                                                <div class="d-flex ms-2">
                                                    <v-datepicker
                                                        v-model="liquidation.returnedDate"
                                                        format="DD.MM.YYYY"
                                                        input-class="form-control"
                                                    />
                                                    <v-timepicker
                                                        v-model="liquidation.returnedAt"
                                                        class="shrunk ms-1"
                                                        input-class="form-control"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div v-if="selectedLiquidationTab === 'comments'">
                                <div class="mb-2">
                                    <label class="form-label mt-2 mb-1">Коментар:</label>
                                    <textarea
                                        v-model="formComment"
                                        class="form-control"
                                        rows="3"
                                    />
                                    <div class="d-flex justify-content-end mt-2">
                                        <v-button
                                            :loading="isLoadingSaveComment"
                                            color="primary"
                                            @click="saveComment"
                                        >
                                            Зберегти
                                        </v-button>
                                    </div>
                                </div>

                                <div>
                                    <div
                                        v-for="comment in comments"
                                        :key="comment.id"
                                        class="liquidation__comment"
                                    >
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="fw-bold">{{ getEmployeeFullName(comment.employee) }}</div>
                                            <div class="liquidation__comment-date">{{ getFormattedDateTime(comment.created_at) }}</div>
                                        </div>

                                        <div>{{ comment.comment }}</div>
                                    </div>
                                </div>
                            </div>
                            <div v-if="selectedLiquidationTab === 'additional_info'">
                                <div class="d-flex justify-content-between mt-2">
                                    <div>
                                        <div class="liquidation-form-field__item">
                                            <div class="fire-square__label">Площа пожежі:</div>
                                            <input
                                                v-model="fireSquare"
                                                type="number"
                                                class="form-control fire-square__input ms-2"
                                                min="0"
                                            >
                                        </div>
                                        <div class="liquidation-form-field__item">
                                            <div class="fire-square__label">Площа пожежі після локалізації:</div>
                                            <input
                                                v-model="fireSquareAfterLocalization"
                                                type="number"
                                                class="form-control fire-square__input ms-2"
                                                min="0"
                                            >
                                        </div>
                                    </div>
                                    <div>
                                        <v-button color="primary">Зберегти</v-button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <forward-emergency-request-modal
                    :show="showForwardEmergencyRequestModal"
                    @setLiquidationRequestIsAccepted="setLiquidationRequestIsAccepted"
                    @closeModal="closeForwardEmergencyRequestModal"
                />
                <request-additional-units-modal
                    :show="showRequestAdditionalUnitsModal"
                    @closeModal="closeRequestAdditionalUnitsModal"
                />
                <close-emergency-liquidation-modal
                    :show="showCloseEmergencyLiquidationModal"
                    @closeModal="closeCloseEmergencyLiquidationModal"
                />
            </div>
        </div>
    </MainLayout>
</template>

<script>
import MainLayout from "../../layouts/MainLayout.vue";
import {
    acceptLiquidation,
    getEmergency,
    getEmergencyComments,
    storeEmergencyComment,
    syncLiquidations
} from "../../api/emergencyService";
import VButton from "../../components/common/VButton.vue";
import {getVehicles} from "../../api/vehicleService";
import {getUnits} from "../../api/guardService";
import ForwardEmergencyRequestModal from "../../components/emergency/EmergencyRequestForwardModal.vue";
import RequestAdditionalUnitsModal from "../../components/emergency/RequestAdditionalUnitsModal.vue";
import CloseEmergencyLiquidationModal from "../../components/emergency/CloseEmergencyLiquidationModal.vue";
import closeEmergencyLiquidationModal from "../../components/emergency/CloseEmergencyLiquidationModal.vue";

export default {
    name: "EmergencyDetailPage",
    components: {
        CloseEmergencyLiquidationModal,
        RequestAdditionalUnitsModal, ForwardEmergencyRequestModal, VButton, MainLayout},
    data() {
        return {
            emergency: null,
            isLoadedEmergency: false,

            units: [],
            isLoadedUnits: false,

            vehicles: [],
            isLoadedVehicles: false,

            fireSquare: null,
            fireSquareAfterLocalization: null,

            liquidations: [
                {
                    id: null,
                    unit: null,
                    vehicle: null,
                    departuredDate: new Date(),
                    departuredAt: null,
                    arrivedDate: new Date(),
                    arrivedAt: null,
                    firstBarrelDeliveredDate: new Date(),
                    firstBarrelDeliveredAt: null,
                    localizedDate: new Date(),
                    localizedAt: null,
                    liquidatedDate: new Date(),
                    liquidatedAt: null,
                    returnedDate: new Date(),
                    returnedAt: null,
                },
            ],

            isLoadingAcceptEmergency: false,

            showForwardEmergencyRequestModal: false,
            showRequestAdditionalUnitsModal: false,
            showCloseEmergencyLiquidationModal: false,

            liquidationTabs: [
                {
                    value: "unit",
                    label: "Відділення",
                },
                {
                    value: "comments",
                    label: "Нотатки",
                },
                {
                    value: "additional_info",
                    label: "Додаткова інформація",
                },
            ],
            selectedLiquidationTab: "unit",

            isLoadingSyncLiquidatons: false,

            comments: [],
            isLoadingComments: false,

            formComment: "",
            isLoadingSaveComment: false,
        };
    },
    computed: {
        user() {
            return this.$store.state.auth.user;
        },
        isReadEmergencyLiquidation() {
            return this.emergency.liquidation_request.is_accepted !== null;
        },
        isAcceptedEmergencyLiquidation() {
            return this.emergency.liquidation_request.is_accepted;
        },
        unitsUsedCount() {
            return this.liquidations.filter(item => item.id).length;
        },
        selectedUnits() {
            return this.liquidations.filter(item => item.unit).map(item => item.unit.value);
        },
        freeUnits() {
            return this.units.filter(item => !this.selectedUnits.includes(item.value));
        },
    },
    beforeRouteUpdate(to, from, next) {
        this.isLoadedEmergency = false;

        this.fetchInitialData(to.params.id);

        next();
    },
    mounted() {
        this.fetchInitialData();
    },
    methods: {
        fetchInitialData(emergencyId = null) {
            this.fetchEmergency(emergencyId);
            this.fetchUnits();
            this.fetchVehicles();
            this.fetchComments();
        },
        fetchEmergency(emergencyId = null) {
            getEmergency(emergencyId ?? this.$route.params.id)
                .then(response => {
                    if (this.$route.params.id === response.data.id.toString()) {
                        this.processEmergencyData(response.data);
                        this.isLoadedEmergency = true;
                    }
                });
        },
        acceptLiquidation() {
            this.isLoadingAcceptEmergency = true;

            acceptLiquidation(this.emergency.id)
                .then(() => {
                    this.setLiquidationRequestIsAccepted(true);
                })
                .finally(() => {
                    this.isLoadingAcceptEmergency = false;
                });
        },
        setLiquidationRequestIsAccepted(value) {
            this.emergency.liquidation_request.is_accepted = value;
        },
        fetchUnits() {
            getUnits()
                .then(response => {
                    this.units = response.data.map(item => ({
                        value: item.id,
                        label: item.id + " | " + this.getEmployeeFullName(item.commander),
                    }));
                })
                .finally(() => {
                    this.isLoadedUnits = true;
                });
        },
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
        fetchComments() {
            this.isLoadingComments = true;

            getEmergencyComments(this.$route.params.id)
                .then(response => {
                    this.comments = response.data;
                })
                .finally(() => {
                    this.isLoadingComments = false;
                });
        },
        getEmployeeFullName(employee) {
            return employee.last_name + " " + employee.first_name + " " + employee.patronymic;
        },
        getFormattedDateTime(datetime) {
            return moment(datetime).format("DD.MM.YYYY HH:mm:ss");
        },
        openForwardEmergencyRequestModal() {
            this.showForwardEmergencyRequestModal = true;
        },
        closeForwardEmergencyRequestModal() {
            this.showForwardEmergencyRequestModal = false;
        },
        openRequestAdditionalUnitsModal() {
            this.showRequestAdditionalUnitsModal = true;
        },
        closeRequestAdditionalUnitsModal() {
            this.showRequestAdditionalUnitsModal = false;
        },
        openCloseEmergencyLiquidationModal() {
            this.showCloseEmergencyLiquidationModal = true;
        },
        closeCloseEmergencyLiquidationModal() {
            this.showCloseEmergencyLiquidationModal = false;
        },
        setSelectedLiquidationTab(value) {
            this.selectedLiquidationTab = value;
        },
        addLiquidationUnit() {
            this.liquidations.push({
                id: null,
                unit: null,
                vehicle: null,
                departuredDate: new Date(),
                departuredAt: null,
                arrivedDate: new Date(),
                arrivedAt: null,
                firstBarrelDeliveredDate: new Date(),
                firstBarrelDeliveredAt: null,
                localizedDate: new Date(),
                localizedAt: null,
                liquidatedDate: new Date(),
                liquidatedAt: null,
                returnedDate: new Date(),
                returnedAt: null,
            });
        },
        removeLiquidationUnit(key) {
            this.liquidations.splice(key, 1);
        },
        saveLiquidationUnits() {
            this.isLoadingSyncLiquidatons = true;

            const payload = {
                liquidations: this.liquidations.map(liquidation => ({
                    id: liquidation.id,
                    unit_id: liquidation.unit.value,
                    vehicle_id: liquidation.vehicle.value,
                    departured_at: this.unionDateAndTime(liquidation.departuredDate, liquidation.departuredAt),
                    arrived_at: this.unionDateAndTime(liquidation.arrivedDate, liquidation.arrivedAt),
                    first_barrel_delivered_at: this.unionDateAndTime(liquidation.firstBarrelDeliveredDate, liquidation.firstBarrelDeliveredAt),
                    localized_at: this.unionDateAndTime(liquidation.localizedDate, liquidation.localizedAt),
                    liquidated_at: this.unionDateAndTime(liquidation.liquidatedDate, liquidation.liquidatedAt),
                    returned_at: this.unionDateAndTime(liquidation.returnedDate, liquidation.returnedAt),
                })),
            };

            syncLiquidations(this.emergency.id, payload)
                .then(response => {
                    this.processEmergencyData(response.data);
                })
                .finally(() => {
                    this.isLoadingSyncLiquidatons = false;
                });
        },
        unionDateAndTime(date, time) {
            if (!date || !time) {
                return null;
            }
            return moment(date).format("YYYY-MM-DD") + " " + time.HH + ":" + time.mm + ":00";
        },
        processEmergencyData(data) {
            this.emergency = data;

            if (!data.liquidations) {
                return;
            }

            this.liquidations = data.liquidations.map(liquidation => {
                const departuredAt = liquidation.departured_at
                    ? moment(liquidation.departured_at)
                    : null;
                const arrivedAt = liquidation.arrived_at
                    ? moment(liquidation.arrived_at)
                    : null;
                const firstBarrelDeliveredAt = liquidation.first_barrel_delivered_at
                    ? moment(liquidation.first_barrel_delivered_at)
                    : null;
                const localizedAt = liquidation.localized_at
                    ? moment(liquidation.localized_at)
                    : null;
                const liquidatedAt = liquidation.liquidated_at
                    ? moment(liquidation.liquidated_at)
                    : null;
                const returnedAt = liquidation.returned_at
                    ? moment(liquidation.returned_at)
                    : null;


                return {
                    id: liquidation.id,
                    unit: liquidation.unit_id
                        ? {value: liquidation.unit_id, label: liquidation.unit.number + " | " + this.getEmployeeFullName(liquidation.unit.commander)}
                        : null,
                    vehicle: liquidation.vehicle_id
                        ? {value: liquidation.vehicle_id, label: liquidation.vehicle.model.name + " | " + liquidation.vehicle.license_plate}
                        : null,
                    departuredDate: departuredAt
                        ? departuredAt.toDate()
                        : new Date(),
                    departuredAt: departuredAt
                        ? {HH: departuredAt.format("HH"), mm: departuredAt.format("mm")}
                        : null,
                    arrivedDate: arrivedAt
                        ? arrivedAt.toDate()
                        : new Date(),
                    arrivedAt: arrivedAt
                        ? {HH: arrivedAt.format("HH"), mm: arrivedAt.format("mm")}
                        : null,
                    firstBarrelDeliveredDate: firstBarrelDeliveredAt
                        ? firstBarrelDeliveredAt.toDate()
                        : new Date(),
                    firstBarrelDeliveredAt: firstBarrelDeliveredAt
                        ? {HH: firstBarrelDeliveredAt.format("HH"), mm: firstBarrelDeliveredAt.format("mm")}
                        : null,
                    localizedDate: localizedAt
                        ? localizedAt.toDate()
                        : new Date(),
                    localizedAt: localizedAt
                        ? {HH: localizedAt.format("HH"), mm: localizedAt.format("mm")}
                        : null,
                    liquidatedDate: liquidatedAt
                        ? liquidatedAt.toDate()
                        : new Date(),
                    liquidatedAt: liquidatedAt
                        ? {HH: liquidatedAt.format("HH"), mm: liquidatedAt.format("mm")}
                        : null,
                    returnedDate: returnedAt
                        ? returnedAt.toDate()
                        : new Date(),
                    returnedAt: returnedAt
                        ? {HH: returnedAt.format("HH"), mm: returnedAt.format("mm")}
                        : null,
                }
            });
        },
        saveComment() {
            this.isLoadingSaveComment = true;

            const payload = {
                comment: this.formComment,
            };

            storeEmergencyComment(this.emergency.id, payload)
                .then((response) => {
                    this.formComment = "";
                    this.comments.unshift(response.data);
                })
                .finally(() => {
                    this.isLoadingSaveComment = false;
                });
        },
    },
}
</script>

<style scoped lang="scss">
.emergency-detail-card {
    width: 950px;
    margin: 50px auto 50px auto;
    padding: 15px 15px 30px 15px;
}
.form-select {
    width: 350px;
}
.form-select__label {
    margin: 6px 6px 0 0;
}
.liquidation-time__label {
    width: 168px;
    text-align: right;
}
.liquidation-form-field__item {
    display: flex;
    align-items: center;
}
.liquidation-form-field__item + .liquidation-form-field__item {
    margin-top: 5px;
}
.fire-square__label {
    width: 130px;
    text-align: right;
}
.fire-square__input {
    width: 200px;
}
.btn-add-unit {
    position: absolute !important;
    right: 0;
    top: 0;
}

.liquidation__tabs {
    display: flex;
    width: 100%;
}
.liquidation__tab {
    text-align: center;
    padding: 10px 0;
    background-color: #eeeff0;
    border: 1px solid #dee2e6;
    width: 100%;
    cursor: pointer;

    &+& {
        border-left: none;
    }

    &:hover, &.selected {
        background-color: #dbdee1;
    }

    &:active {
        background-color: #c9cacb;
    }
}

.liquidation__tab-content {
    border: 1px solid #dee2e6;
    border-top: none;
    padding: 10px 20px;
    min-height: 370px;
}

.liquidation__unit {
    padding-top: 15px;
    margin-top: 15px;
    border-top: 1px solid #dee2e6;
}

.liquidation__comment {
    border-top: 1px solid #dee2e6;
    padding: 10px 0;
}
.liquidation__comment-date {
    font-size: 12px;
    color: #4c4c4c;
    margin-left: 8px;
}
</style>
