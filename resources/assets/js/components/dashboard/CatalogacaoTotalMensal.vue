<template>
    <div>
        <q-section>
            <q-card>
                <q-separator />
                <q-card-section>

                </q-card-section>
                <q-table v-if="render" title="Catalogação total mensal" :data="dataTable" :columns="columns"
                    style="width: 95%" color="primary" row-key="name" :pagination="{ rowsPerPage: 20 }">
                    <template v-slot:top-right>
                        <q-btn color="primary" icon-right="archive" label="Export to csv" no-caps
                            @click="exportToCsv" />
                    </template>

                </q-table>
            </q-card>
        </q-section>
        <q-separator />
        <q-card-section v-if="render">
            <VueApexCharts height="450" type="line" :options="chartOptions" :series="mapSeries" />
        </q-card-section>
    </div>
</template>

<script>
import { exportTable } from "@composables/ToCsv";
import VueApexCharts from "vue-apexcharts";

export default {
    name: "CatalogacaoTotalMensal",
    components: {
        VueApexCharts,
    },
    data () {
        return {
            columns: [
                {
                    name: "mes",
                    align: "left",
                    label: "Mês",
                    field: "mes",
                    sortable: true,
                    width: "100%"

                },
                {
                    name: "Quantidade",
                    label: "Quantidade",
                    field: "quantidade"
                },
            ],
            dataTable: [],
            mapSeries: [],
            render: false,
            // Inicio da configuração do gráfico
            chartOptions: {
                chart: {
                    height: 350,
                    type: 'area'
                },
                title: {
                    text: "Catalogação Total mensal",
                    align: "center",
                },

                dataLabels: {
                    enabled: false,
                },
                xaxis: {
                    categories: [],
                },
            },
        }
    },
    created () {
        this.getDataTable();
    },
    methods: {
        exportToCsv () {
            exportTable(this.dataTable, this.columns);
        },

        async getDataTable () {
            this.$q.loading.show();
            const { data } = await axios.get(`/dashboard/catalogacao-total-mensal`);
            if (data.success) {
                this.dataTable = data.metadata;
                // define as as cetegorias com o spread operator (...)
                this.chartOptions = {
                    ...this.chartOptions,
                    ...{
                        xaxis: {
                            categories: data.metadata.map((item) => item.mes),
                        },
                    },
                };
                // define as series
                this.mapSeries = [
                    {
                        name: "Download",
                        data: data.metadata.map((item) => item.quantidade),
                    },
                ];
                // renderiza
                this.render = data.success;
            }
            this.$q.loading.hide();
        },
    },
};
</script>
<style scoped>

</style>

