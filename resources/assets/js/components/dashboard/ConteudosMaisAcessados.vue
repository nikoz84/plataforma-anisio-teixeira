<template>
    <div>
        <q-section>
            <q-card>
                <q-separator />
                <q-card-section>

                </q-card-section>
                <q-table v-if="render" title="Conteúdos Mais Acessados" :data="dataTable" :columns="columns"
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
    name: "ConteudosMaisAcessados",
    components: {
        VueApexCharts,
    },
    data () {
        return {
            columns: [
                {
                    name: "title",
                    align: "left",
                    label: "Título",
                    field: "title",
                    sortable: true,
                    width: "100%"

                },
                {
                    name: "Quantidade",
                    label: "Quantidade",
                    field: "qt_access"
                },
            ],
            dataTable: [],
            mapSeries: [],
            render: false,
            // Inicio da configuração do gráfico
            chartOptions: {
                chart: {
                    id: "vuechart-conteudos",
                    height: 430,
                    type: "bar",
                },
                title: {
                    text: "Conteúdos mais acessados",
                    align: "center",
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        // horizontal: true,
                        dataLabels: {
                            position: 'top',
                        },
                    },
                },//plotOptions
                dataLabels: {
                    enabled: true,
                    offsetX: -6,
                    style: {
                        fontSize: '12px',
                        colors: ['#00ffff']
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
            const { data } = await axios.get(`/dashboard/conteudos-mais-acessados`);
            if (data.success) {
                this.dataTable = data.metadata;
                // define as as cetegorias com o spread operator (...)
                this.chartOptions = {
                    ...this.chartOptions,
                    ...{
                        xaxis: {
                            categories: data.metadata.map((item) => item.title),
                        },
                    },
                };
                // define as series
                this.mapSeries = [
                    {
                        name: "Download",
                        data: data.metadata.map((item) => item.qt_access),
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

