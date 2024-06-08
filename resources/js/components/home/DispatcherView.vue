<template>
    <div class="row mx-0">
        <div class="col-md-3 dispatcher-sidebar">
            <div class="dispatcher-sidebar__caption">
                Надзвичайні ситуації:
            </div>
            <div class="dispatcher-sidebar__list">
                <div v-if="isLoadingEmergencies" class="dispatcher-sidebar__loader">Loading...</div>
                <div v-else-if="emergencies.length === 0" class="dispatcher-sidebar__no-data">
                    No data
                </div>
                <div v-else>
                    <v-button
                        v-for="emergency in emergencies"
                        :key="emergency.id"
                        :to="`/emergencies/${emergency.id}`"
                        class="dispatcher-sidebar__item"
                        :class="{
                            unread: emergency.liquidation_request.is_accepted === null,
                            current: isCurrentRoute(emergency.id),
                        }"
                    >
                        <div class="line-height-20px">{{ emergency.type.name + " | " + getFormattedDateTime(emergency.reported_at) }}</div>
                        <div class="line-height-20px">{{ emergency.address }}</div>
                        <div class="line-height-20px">{{ emergency.workplace_name }}</div>
                    </v-button>
                </div>
            </div>
        </div>
        <div class="col-md-9 dispatcher-content">
            <slot/>
        </div>
    </div>
</template>

<script>
import VButton from "../common/VButton.vue";

export default {
    name: "DispatcherView",
    components: {VButton},
    computed: {
        emergencies() {
            return this.$store.state.emergencies.emergencies;
        },
        isLoadingEmergencies() {
            return this.$store.state.emergencies.isLoadingEmergencies;
        },
    },
    mounted() {
        this.$store.dispatch("fetchEmergencies");
    },
    methods: {
        getFormattedDateTime(timestamp) {
            return moment(timestamp).format("DD.MM.YYYY HH:mm:ss")
        },
        isCurrentRoute(id){
            return this.$route.name === 'emergency_detail' && this.$route.params.id === id.toString();
        }
    }
}
</script>

<style scoped lang="scss">
.dispatcher-sidebar {
    background-color: #f3f3f3;
    min-height: 100vh;
    padding: 0;
}
.dispatcher-sidebar__caption {
    font-weight: bold;
    padding: 15px 20px;
    background-color: #eee;
}
.dispatcher-sidebar__loader, .dispatcher-sidebar__no-data {
    padding: 15px 20px;
    text-align: center;
}
.dispatcher-sidebar__item {
    width: 100%;
    text-align: left;
    border-radius: 0;
    padding: 10px 5px 10px 20px;
    background-color: #fcfcfc;
    border-bottom: 1px solid #e9e9e9;

    &:hover, &.current {
        background-color: #dadada;
    }
    &:active {
        background-color: #bbbbbb;
    }

    &.unread {
        background-color: #ff9999;

        &:hover, &.current {
            background-color: #e16868;
        }
        &:active {
            background-color: #bd3d3d;
        }
    }
}

.dispatcher-content {
    padding: 16px;
}
</style>
