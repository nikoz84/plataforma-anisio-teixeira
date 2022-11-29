<template>
    <q-card>
        <q-card-section v-if="!isDashboard">
            <div class="text-dark text-h6">Filtros</div>
            <div class="row q-gutter-md">
                <q-select class="col" clearable dense v-model="mes" label-color="primary" :options="filtroMeses"
                    label="Filtrar por mês" />
                <q-select class="col" clearable dense v-model="ano" label-color="primary" :options="filtroAnos"
                    label="Filtrar por ano" />

                <q-select class="col" dense clearable v-model="usuario" option-value="id" option-label="name"
                    stack-label emit-value map-options label-color="primary" :options="usuariosFiltrados" use-input
                    @filter="filtrarNome" label="Filtrar por usuário" />

                <q-select class="col" dense v-model="ordenarPor" label-color="primary" :options="filtroOrdenarPor"
                    option-value="id" option-label="nome" stack-label emit-value map-options label="Ordenar por" />

            </div>
            <div class="row q-mt-lg q-gutter-md justify-end">
                <q-btn class="col-2" color="primary" label="Pesquisar" @click="getDataTable" />
                <q-btn class="col-2" color="secondary" :to="buttonRedirect.url">
                    {{ buttonRedirect.label }}
                </q-btn>
            </div>
        </q-card-section>
        <q-card-section v-if="!isDashboard">
            <q-table v-if="render" :title="title" :data="dataTable" :columns="columns" color="primary" row-key="id"
                :pagination="{ rowsPerPage: limit }">
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
import { date } from 'quasar'
export default {
    name: 'CatalogacaoMensalPorUsuario',
    components: {
        VueApexCharts
    },
    props: ['isDashboard'],
    data () {
        return {
            filtroMeses: [],
            filtroUsuarios: [],
            filtroOrdenarPor: [],
            filtroAnos: [],
            usuariosFiltrados: [],
            limit: 20,
            mes: '',
            ano: '',
            usuario: null,
            dateInicio: '',
            dateFim: '',
            ordenarPor: null,
            dataTable: [],
            mapSeries: [],
            render: false,
            columns: [
                { name: 'ano', align: 'center', label: 'Ano', field: 'ano' },
                { name: 'mes', align: 'center', label: 'Mês', field: 'mes' },
                { name: 'Nome', align: 'left', label: 'Nome', field: 'name', format: val => val.toUpperCase().replace(/[-\\]/g, '').split(' ', 4).join(' ') },
                { name: 'Total', label: 'total', field: 'total' }
            ],
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
        },
        title () {
            return `Catalogação mensal por usuário`
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
            const { data } = await axios.get(`/dashboard/catalogacao-mensal-por-usuario`, {
                params: {
                    id: this.usuario,
                    limit: this.limit,
                    ordenarPor: this.ordenarPor,
                    mes: this.mes,
                    ano: this.ano,
                }
            })
            this.prepararDados(data)
            this.$q.loading.hide();
        },
        async prepararDados (data) {
            if (data.success) {
                this.dataTable = data.metadata.data;
                // define as as cetegorias com o spread operator (...)
                this.chartOptions = {
                    ...this.chartOptions,
                    ...{
                        xaxis: {
                            categories: data.metadata.data.map((item) => item.mes),
                        },
                    },
                };
                // define as series
                this.mapSeries = [
                    {
                        name: "Quantidade",
                        data: data.metadata.data.map((item) => item.total),
                    },
                ];
            }
            // renderiza
            this.render = true;
        },
        async getFiltros () {
            const { data } = await axios(`/dashboard/filtros/catalogacao-mensal-por-usuario`);
            if (data.success) {
                this.filtroUsuarios = data.metadata.usuarios;
                this.filtroOrdenarPor = data.metadata.ordenarPor;
                this.filtroAnos = data.metadata.anos
                this.filtroMeses = data.metadata.meses;
            }
        },
        filtrarNome (val, update) {
            update(() => {
                if (val === '') {
                    this.usuariosFiltrados = this.filtroUsuarios
                } else {
                    const needle = val.toLowerCase()
                    this.usuariosFiltrados = this.filtroUsuarios.filter(v => v.name.toLowerCase().indexOf(needle) > -1)
                }
            })
        }
    }
}
</script>

