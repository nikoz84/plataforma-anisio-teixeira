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
    name: "TagsMaisProcuradas",
    components: {
        VueApexCharts,
    },
    props: ['isDashboard'],
    data () {
        return {
            MapOptionsAnos: [],
            mapOptionsMes: [],
            anoMultiple: null,
            mesMultiple: null,
            columns: [
                {
                    name: "name",
                    align: "center",
                    label: "Nome",
                    field: "name",
                    sortable: true,
                },
                { name: "searched", label: "Procuradas", field: "searched" },
            ],
            dataTable: [],
            mapSeries: [],
            render: false,
            // Inicio da configuração do gráfico
            chartOptions: {
                chart: {
                    id: "vuechart-Tags",
                    height: 430,
                    width: "100%",
                    type: "bar",
                },
                title: {
                    text: "Palavras-Chave",
                    align: "center",
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                    },
                },
                title: {
                    text: "Palavras chave mais procuradas",
                    align: "left",
                    margin: 55,
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
        };
    },
    computed: {
        buttonRedirect () {
            return this.isDashboard ?
                { label: 'Ver relatório completo', url: '/admin/dashboard/tags-mais-procuradas' } :
                { label: 'Voltar', url: '/admin/dashboard/listar' }
        }
    },
    computed: {
        buttonRedirect () {
            return this.isDashboard ?
                {
                    label: 'Ver relatório completo', url: '/admin/dashboard/tags-mais-procuradas'
                } :
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
                        name: "Total",
                        data: data.metadata.map((item) => item.searched),
                    },
                ];

                this.MapOptionsName = data.metadata.map((item) => item.name),
                    // this.MapOptionsMes = data.metadata.map((item) => mes),
                    // renderiza
                    this.render = data.success;
            }
            this.$q.loading.hide();
        },
    },
};
</script>