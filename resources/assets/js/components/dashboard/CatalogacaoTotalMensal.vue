<template>
    <q-card>
        <q-card-section v-if="!isDashboard">
            <div class="text-dark text-h6">Filtros</div>
            <div class="row q-gutter-md">
                <q-input class="col" v-model="start" filled type="date" clearable />
                <q-input class="col" v-model="end" filled type="date" clearable />
                <q-select class="col" dense v-model="ordenarPor" label-color="primary" :options="filtroOrdenarPor"
                    option-value="id" option-label="nome" stack-label emit-value map-options label="Ordenar por"
                    clearable />
            </div>
            <div class="row q-mt-lg q-gutter-md justify-end">
                <q-btn class="col-2" color="primary" label="Pesquisar" @click="getDataTable" />
                <q-btn class="col-2" color="secondary" :to="buttonRedirect.url">
                    {{ buttonRedirect.label }}
                </q-btn>
            </div>
        </q-card-section>
        <q-card-section v-if="!isDashboard">
            <q-table v-if="render" title="Catalogação total mensal" :data="dataTable" :columns="columns" color="primary"
                row-key="name" :pagination="{ rowsPerPage: 20 }">
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
    name: "CatalaogacaoTotalMensal",
    components: {
        VueApexCharts,
    },
    props: ['isDashboard'],
    data () {
        return {
            start: '',
            end: '',
            filtroOrdenarPor: [],
            ordenarPor: null,
            columns: [
                {
                    name: "periodo", align: "left", label: "Período", field: "periodo", sortable: true,
                },
                { name: "quantidade", label: "Quantidade", field: "quantidade" },
            ],
            dataTable: [],
            mapSeries: [],
            render: false,
            // Inicio da configuração do gráfico
            chartOptions: {
                chart: {

                    height: 430,
                    width: "100%",
                    type: "bar",
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800,
                        animateGradually: {
                            enabled: true,
                            delay: 200
                        },
                        dynamicAnimation: {
                            enabled: true,
                            speed: 350
                        }
                    }
                },
                title: {
                    text: "Catalogação total mensal",
                    align: "left",
                    margin: 55,
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
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
            this.render = false;
            this.$q.loading.show();
            const { data } = await axios.get(`/dashboard/catalogacao-total-mensal`, {
                params: {
                    start: this.start,
                    end: this.end,
                    ordenarPor: this.ordenarPor,


                },
            })

            this.prepararDados(data)
            this.$q.loading.hide();
        },
        async prepararDados (data) {
            if (data.success) {
                this.dataTable = data.metadata;
                this.chartOptions = {
                    ...this.chartOptions,
                    ...{
                        xaxis: {
                            categories: data.metadata.map((item) => item.periodo),
                        },
                    },
                };
                this.mapSeries = [
                    {
                        name: "Quantidade",
                        data: data.metadata.map((item) => item.quantidade),
                    },
                ];

            }
            this.render = true;
        },
        async getFiltros () {

            const { data } = await axios.get(`/dashboard/filtros/catalogacao-total-mensal`);

            if (data.success) {
                this.filtroOrdenarPor = data.metadata.ordenarPor;

            }
        }
    },
};
</script>


