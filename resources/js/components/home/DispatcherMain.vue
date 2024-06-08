<template>
    <div class="card dispatcher-content-card">
        <div class="card-body">
            <h3 class="text-center mb-5">Пункт зв'язку</h3>

            <div class="guard__units">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Командир</th>
                        <th scope="col">Статус</th>
                        <th scope="col">ТЗ для ліквідації НС</th>
                    </tr>
                    </thead>
                    <tbody v-if="!isLoadingUnits">
                    <tr v-for="unit in units" :key="unit.id">
                        <th scope="row">{{ unit.number }}</th>
                        <td>{{ getEmployeeFullName(unit.commander) }}</td>
                        <td>{{ getUnitStatus(unit) }}</td>
                        <td>{{ getEmergencyLiquidationVehicle(unit) }}</td>
                    </tr>
                    </tbody>
                </table>
                <div v-if="isLoadingUnits" class="units-loader">
                    Loading...
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {getUnits} from "../../api/guardService";
import VButton from "../common/VButton.vue";

export default {
    name: "DispatcherView",
    components: {VButton},
    data() {
        return {
            units: [],
            isLoadingUnits: false,
        };
    },
    mounted() {
        this.fetchUnits();
    },
    methods: {
        fetchUnits() {
            this.isLoadingUnits = true;

            getUnits()
                .then(response => {
                    this.units = response.data;
                })
                .finally(() => {
                    this.isLoadingUnits = false;
                });
        },
        getEmployeeFullName(employee) {
            return employee.last_name + " " + employee.first_name + " " + employee.patronymic;
        },
        getUnitStatus(unit) {
            if (! unit.active_emergency_liquidation) {
                return "У бойовій готовності";
            } else if (unit.active_emergency_liquidation.liquidated_at) {
                return "Повернення до ДПРЧ";
            } else if (unit.active_emergency_liquidation.arrived_at) {
                return "Ліквідація НС";
            } else if (unit.active_emergency_liquidation.departured_at) {
                return "На шляху до місця НС";
            } else {
                return "Ліквідація НС";
            }
        },
        getEmergencyLiquidationVehicle(unit) {
            if (!unit.active_emergency_liquidation) {
                return "-";
            }

            const vehicle = unit.active_emergency_liquidation.vehicle;

            return vehicle.model.name + " | " + vehicle.license_plate
        },
    }
}
</script>

<style scoped>
.dispatcher-content-card {
    width: 800px;
    margin: 50px 220px;
    padding: 15px 15px 30px 15px;
}
.units-loader {
    text-align: center;
    padding: 10px 20px 20px 20px;
}
</style>
