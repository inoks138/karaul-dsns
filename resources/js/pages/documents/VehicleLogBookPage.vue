<template>
    <MainLayout>
        <div class="d-flex justify-content-center">
            <div class="card document-card">
                <div class="card-body">
                    <h3 class="text-center mb-5">Журнал стройових записок</h3>

                    <label class="form-label">Оберіть період, за який потріно сформувати записи з Журналу стройових записок:</label>
                    <v-datepicker
                        v-model="formData.date"
                        class="w-100"
                        range
                    />

                    <label class="form-label mt-4">Оберіть ДПРЧ:</label>
                    <v-select
                        v-model="formData.firehouse"
                        :options="firehouses"
                        :loading="!isLoadedFirehouses"
                        class="form-control"
                    />

                    <label class="form-label mt-4">Оберіть формат документу:</label>
                    <v-select
                        v-model="formData.documentMime"
                        :options="documentMimes"
                        class="form-control"
                    />

                    <v-button
                        class="w-100 mt-4"
                        color="primary"
                    >
                        Завантажити
                    </v-button>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script>
import VButton from "../../components/common/VButton.vue";
import MainLayout from "../../layouts/MainLayout.vue";
import {getFirehouses} from "../../api/workplaceService";

export default {
    name: "DispatcherLogBookPage",
    components: {MainLayout, VButton},
    data() {
        return {
            formData: {
                date: null,
                firehouse: null,
                documentMime: {
                    value: 'pdf',
                    label: '.pdf',
                },
            },

            firehouses: [],
            isLoadedFirehouses: false,

            documentMimes: [
                {
                    value: 'pdf',
                    label: '.pdf',
                },
                {
                    value: 'docx',
                    label: '.docx',
                },
            ]
        };
    },
    mounted() {
        this.fetchFirehouses();
    },
    methods: {
        fetchFirehouses() {
            getFirehouses()
                .then(response => {
                    this.firehouses = response.data.map(item => ({
                        value: item.id,
                        label: "ДПРЧ-" + item.number,
                    }));
                })
                .finally(() => {
                    this.isLoadedFirehouses = true;
                })
        }
    },
}
</script>

<style scoped>
.document-card {
    width: 550px;
    margin: 50px 0;
    padding: 15px 15px 30px 15px;
}
</style>
