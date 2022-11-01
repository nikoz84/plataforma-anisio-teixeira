<template>
    <q-card>
        <q-card-section v-if="!isDashboard">
            <div class="text-dark text-h6">Filtros</div>
            <div class="row q-gutter-md">
                <q-select class="col" dense v-model="nome" label-color="primary" :options="filtroUsuario"
                    label="Filtrar por usuário" />
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
import VueApexCharts from "vue-apexcharts";
import { exportTable } from "@composables/ToCsv";

export default {
    name: 'CatalogacaoMensalPorUsuario',
    components: {
        VueApexCharts
    },
    props: ['isDashboard'],
    data () {
        return {
            columns: [

                { name: 'Nome', align: 'center', label: 'Nome', field: 'name' },
                { name: 'Total', label: 'total', field: 'total' }

            ],
            filtroUsuario: [],
            filtroOrdenarPor: [],
            nome: null,
            ordenarPor: null,
            dataTable: [],
            mapSeries: [],
            render: false,

            //Inicia configuração do gráfico
            chartOptions: {
                chart: {
                    height: 430,
                    type: "bar",
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
                title: {
                    text: "Catalogação mensal total por usúario",
                    align: "left",
                    margin: 55,
                },
                dataLabels: {
                    enabled: false,
                    offsetX: -6,
                    style: {
                        fontSize: '12px',
                        colors: ['#008B8B']
                    }
                },
                xaxis: {
                    categories: [],
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
                { label: 'Ver relatório completo', url: '/admin/dashboard/catalogacao-mensal-por-usuario' } :
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
            this.render = false;
            this.$q.loading.show();
            const { data } = await axios.get(`/dashboard/catalogacao-mensal-por-usuario`,
                {
                    params: {
                        nome: this.nome,
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
                            categories: data.metadata.map((item) => item.name),
                        },
                    },
                };
                // define as series
                this.mapSeries = [
                    {
                        name: "Quantidade",
                        data: data.metadata.map((item) => item.total),
                    },
                ];

            }
            // renderiza
            this.render = true;

        },

        async getFiltros () {
            const { data } = await axios(`/dashboard/filtros/catalogacao-mensal-por-usuario`);
            if (data.success) {
                this.filtroUsuario = data.metadata.nome,
                    this.filtroOrdenarPor = data.metadata.ordenarPor
            }
        }
    }
}
</script>
