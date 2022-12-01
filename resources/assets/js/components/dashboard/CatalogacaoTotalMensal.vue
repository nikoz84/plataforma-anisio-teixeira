<template>
    <q-card>
        <q-card-section v-if="!isDashboard">
            <div class="text-dark text-h6">Filtros</div>
            <div class="row q-gutter-md">
                <q-select class="col" dense v-model="mes" label-color="primary" :options="filtroMes"
                    label="Filtrar por mês" />
                <q-select class="col" dense v-model="ordenarPor" label-color="primary" :options="filtroOrdenarPor"
                    option-value="id" option-label="nome" stack-label emit-value map-options label="Ordenar por" />
                <q-btn class="col" color="primary" label="Pesquisar" @click="getDataTable" />
                <q-btn class="col" color="primary" :to="buttonRedirect.url">
                    {{ buttonRedirect.label }}
                </q-btn>

            </div>
        </q-card-section>
        <q-card-section v-if="!isDashboard">
            <q-table v-if="render" title="Conteúdos" :data="dataTable" :columns="columns" color="primary" row-key="name"
                :pagination="{ rowsPerPage: 20 }">
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
    name: "CatalogacaoTotalMensal",
    components: {
        VueApexCharts,
    },
    props: ['isDashboard'],
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
            filtroMes: [],
            filtroOrdenarPor: [],
            dataTable: [],
            mapSeries: [],
            mes: null,
            ordenarPor: null,
            render: false,
            // Inicio da configuração do gráfico
            chartOptions: {
                chart: {
                    height: 350,
                    type: 'area'
                },
                title: {
                    text: "Catalogação total mensal",
                    align: "left",
                    margin: 55,
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
    computed: {
        buttonRedirect () {
            return this.isDashboard ?
                { label: 'Ver relatório completo', url: '/admin/dashboard/catalogacao-total-mensal' } :
                { label: 'Voltar', url: '/admin/dashboard/listar' }
        }
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
            this.$q.loading.show();
            const { data } = await axios.get(`/dashboard/catalogacao-total-mensal`, {
                params: {
                    mes: this.mes,
                    ordenarPor: this.ordenarPor
                }
            });
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

        async getFiltros () {
            const { data } = await axios.get(`/dashboard/filtros/catalogacao-total-mensal`);
            if (data.success) {
                this.filtroMes = data.metadata.mes;
                this.filtroOrdenarPor = data.metadata.ordenarPor;
                this.filtroMes = data.metadata.meses.map(function (e) {
                    return e.label;
                });
            }
        }
    },
};
</script>
<style scoped>

</style>

