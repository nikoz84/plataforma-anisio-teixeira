<template>
    <div>
        <q-section>
            <q-card>
                <q-separator />
                <q-card-section>

                </q-card-section>
                <q-table v-if="render" title="Catalogação por canal" :data="dataTable" :columns="columns"
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
            <VueApexCharts height="450" :options="chartOptions" :series="mapSeries" />
        </q-card-section>
    </div>
</template>

<script>
import { exportTable } from "@composables/ToCsv";
import VueApexCharts from "vue-apexcharts";
export default {
    name: 'TagsMaisProcuradas',
    components: {

        VueApexCharts,
    },
    data () {
        return {
            //
            columns: [
                {
                    name: 'name',
                    align: 'left',
                    label: "Nome",
                    field: "name",
                    sortable: true,
                    width: "100%"
                },
                {
                    name: "Quantidade",
                    label: "Quantidade",
                    field: "searched"

                }
            ],
            dataTable: [],
            mapSeries: [],
            render: false,
            //Inicia configuração do gráfico
            chartOptions: {
                chart: {
                    height: 430,
                    type: "line"
                },

                plotOptions: {
                    bar: {
                        horizontal: false,
                        dataLabels: {
                            position: 'top'
                        },
                    }
                },
                dataLabels: {
                    enabled: true,
                    offsetX: -6,
                    style: {
                        fontSize: '12px',
                        colors: ['#363636']
                    }
                },
                xaxis: {
                    categories: [],
                },
                stroke: {
                    show: true,
                    width: 1,
                    colors: ['#000000']
                },
                tooltip: {
                    shared: true,
                    intersect: false
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
            const { data } = await axios.get(`/dashboard/tags-mais-procuradas`);
            if (data.success) {
                this.dataTable = data.metadata;
                // define as as cetegorias com o spread operator (...)
                this.chartOptions = {
                    ...this.chartOptions,
                    ...{
                        xaxis: {
                            categories: data.metadata.map((item) => item.name),
                        },
                    },
                };
                // define as series
                this.mapSeries = [
                    {
                        name: "searched",
                        data: data.metadata.map((item) => item.searched),
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

