<template>
    <div>
        <q-section>
            <q-card>
                <q-separator />
                <q-card-section>

                </q-card-section>
                <q-table v-if="render" title="Conteúdos Mais Baixados" :data="dataTable" :columns="columns"
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
    name: "ConteudosMaisBaixados",
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
                    name: "qt_downloads",
                    label: "Downloads",
                    field: "qt_downloads"
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
                    width: "100%",
                    type: "line",
                },
                title: {
                    text: "Conteúdos mais baixados",
                    align: "center",
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                    },

                },
                dataLabels: {
                    enabled: false,
                    positions: top,
                },
                xaxis: {
                    categories: [],
                },
                stroke: {
                    curve: 'smooth',
                },

            },
        };
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
            const { data } = await axios.get(`/dashboard/conteudos-mais-baixados`);
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
                        data: data.metadata.map((item) => item.qt_downloads),
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

