<template>
    <q-card>
        <q-card-section v-if="!isDashboard">
            <div class="text-dark text-h6">Filtros</div>
            <div class="row q-gutter-md">
                <q-select class="col" clearable dense v-model="titulo" label-color="primary" :options="filtroTitulo"
                    label="Filtrar por título" />
                <q-select class="col" clearable dense v-model="ano" label-color="primary" :options="filtroAnos"
                    label="Filtrar por ano" />
                <q-select class="col" dense v-model="ordenarPor" label-color="primary" :options="filtroOrdenarPor"
                    option-value="id" option-label="nome" stack-label emit-value map-options label="Ordenar por" />
                <q-btn class="col" color="primary" label="Pesquisar" @click="getDataTable" />
                <q-btn class="col" color="negative" :to="buttonRedirect.url">
                    {{ buttonRedirect.label }}
                </q-btn>

            </div>
        </q-card-section>
        <q-card-section v-if="!isDashboard">

            <q-table v-if="render" title="Conteúdos mais baixados" :data="dataTable" :columns="columns" color="primary"
                row-key="name" width="100%" :pagination="{ rowsPerPage: limit }">

                <template v-slot:top-right>
                    <q-btn color="primary" icon-right="archive" label="Export to csv" no-caps @click="exportToCsv" />
                </template>

            </q-table>
        </q-card-section>
        <q-card-section v-if="render">
            <VueApexCharts height="450" :options="chartOptions" :series="mapSeries" />
        </q-card-section>
        <q-card-actions v-if="isDashboard">
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
    name: "ConteudosMaisBaixados",
    components: {
        VueApexCharts,
    },
    props: ['isDashboard', 'TipoPesquisa'],
    data () {
        return {
            MapOptionsAnos: [],
            mapOptionsMes: [],
            anoMultiple: null,
            mesMultiple: null,
            columns: [
                {
                    name: "titulo",
                    align: "left",

                    label: "Título",
                    field: "title", format: val => val.toUpperCase().replace(/[-\\]/g, '').split(' ', 8).join(' '),
                    sortable: true,
                    width: "100%"

                },
                {
                    name: "Quantidade",
                    label: "Downloads",
                    field: "qt_downloads"
                },
                { name: "qt_downloads", label: "Qt_downloads", field: "qt_downloads" },
            ],
            filtroTitulo: [],
            filtroAnos: [],
            ano: '',
            limit: 20,
            filtroOrdenarPor: [],
            titulo: null,
            ordenarPor: null,
            dataTable: [],
            mapSeries: [],
            render: false,
            // Inicio da configuração do gráfico
            chartOptions: {
                chart: {
                    id: "vuechart-conteudos",
                    height: 500,
                    width: "100%",
                    type: "bar",
                },
                title: {
                    text: "Conteúdos mais baixados",
                    align: "left",
                    margin: 55,
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
            },
        };
    },

    computed: {
        buttonRedirect () {
            return this.isDashboard ?
                {
                    label: 'Ver relatório completo', url: '/admin/dashboard/conteudos-mais-baixados'
                } :
                { label: 'Voltar', url: '/admin/dashboard/listar' }
        },

    },
    created () {
        this.getDataTable();
        this.getFiltros();

    },
    methods: {
        exportToCsv () {
            exportTable(this.dataTable, this.columns);
        },


        async getDataTable () {
            this.render = false;
            this.$q.loading.show();
            const { data } = await axios.get(`/dashboard/conteudos-mais-baixados`, {
                params: {
                    titulo: this.titulo,
                    ano: this.ano,
                    ordenarPor: this.ordenarPor
                }
            })

            this.prepararDados(data)
            this.$q.loading.hide();
        },
        async prepararDados (data) {
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
                        name: "Quantidade de Download",
                        data: data.metadata.map((item) => item.qt_downloads),
                    },
                ];

                this.MapOptionsQt_downloads = data.metadata.map((item) => item.title),
                    // this.MapOptionsMes = data.metadata.map((item) => mes),
                    // renderiza
                    this.render = data.success;
                    }

            this.render = true;
        },


        async getFiltros () {

            const { data } = await axios.get(`/dashboard/filtros/conteudos-mais-baixados`);
            console.log(data);
            if (data.success) {
                this.filtroAnos = data.metadata.anos
                this.filtroTitulo = data.metadata.titulo;
                this.filtroOrdenarPor = data.metadata.ordenarPor;
            }
        }
    },
};
</script>