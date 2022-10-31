<template>
    <q-card>
        <q-card-section v-if="!isDashboard">
            <div class="text-dark text-h6">Filtros</div>
            <div class="q-gutter-md row items-start">
                <div style="min-width: 150px; max-width: 200px">
                    <q-select v-model="mesMultiple" multiple label-color="primary" :options="mapOptionsMes" use-chips
                        stack-label label="Filtrar por meses" />
                </div>
                <div style="min-width: 150px; max-width: 200px">
                    <q-select v-model="anoMultiple" multiple label-color="primary" :options="MapOptionsAnos" use-chips
                        stack-label label="Filtrar por anos" />
                </div>
                <div style="min-width: 150px; max-width: 200px">
                    <q-btn color="primary" label="Pesquisar" size="md" @click='pesquisarFiltros()' />
                </div>
            </div>
        </q-card-section>
        <q-card-section v-if="!isDashboard">
            <q-table title="Conteúdos" :data="dataTable" :columns="columns" color="primary" row-key="name"
                :pagination="{ rowsPerPage: 20 }">
                <template v-slot:top-right>
                    <q-btn color="primary" icon-right="archive" label="Export to csv" no-caps @click="exportToCsv" />
                </template>
            </q-table>
        </q-card-section>

        <q-card-section v-if="render">
            <VueApexCharts height="450" :options="chartOptions" :series="mapSeries" />
        </q-card-section>
        <q-card-actions>
            <q-btn color="primary" class="full-width" :to="buttonRedirect.url" size="sm">
                {{ buttonRedirect.label }}
            </q-btn>
        </q-card-actions>
    </q-card>
</template>

<script>
import { exportTable } from "@composables/ToCsv";
import VueApexCharts from "vue-apexcharts";
export default {
    name: 'ConteudosPorCanal',
    components: {

        VueApexCharts,
    },
    props: ['isDashboard'],
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
                    name: "Total",
                    label: "Total",
                    field: "total"

                }
            ],
            dataTable: [],
            mapSeries: [],
            render: false,
            anoMultiple: null,
            mesMultiple: null,
            //Inicia configuração do gráfico

            chartOptions: {
                chart: {
                    id: "vuechart-conteudos",
                    height: 430,
                    type: "line"
                },
                title: {
                    text: "Catalogação por canal",
                    align: "left",
                    margin: 55,
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
                        colors: ['#008B8B']
                    }
                },
                xaxis: {
                    categories: [],
                    // labels: {
                    //     // show: true,

                    //     style: {
                    //         colors: [],
                    //         fontSize: '2px',
                    //         fontFamily: 'Helvetica, Arial, sans-serif',
                    //         fontWeight: 400,
                    //         cssClass: 'apexcharts-xaxis-label',
                    //     },
                    // },
                },
                stroke: {
                    show: true,
                    width: 3,
                    colors: ['#008B8B']
                },
                tooltip: {
                    shared: true,
                    intersect: false
                },
            },
        }
    },
    computed: {
        buttonRedirect () {
            return this.isDashboard ?
                { label: 'Ver relatório completo', url: '/admin/dashboard/catalogacao-por-canal' } :
                { label: 'Voltar', url: '/admin/dashboard/listar' }
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
            const { data } = await axios.get(`/dashboard/catalogacao-por-canal`);
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
                        name: "Download",
                        data: data.metadata.map((item) => item.total),
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

