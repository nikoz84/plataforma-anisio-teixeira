<template>
    <div>
        <section>
            <q-card>
                <q-separator />
                <q-card-section>
                    <div class="text-dark text-h6">Filtros</div>
                    <div class="q-gutter-md row items-start">
                        <div style="min-width: 250px; max-width: 300px">
                            <q-select v-model="anoMultiple" multiple label-color="primary" use-chips stack-label
                                label="Filtrar por anos" />
                        </div>

                    </div>
                </q-card-section>
                <q-table title="Catalogação Mensal Por Usuário" :data="dataTable" :columns="columns" color="primary"
                    row-key="name">
                    <template v-slot:top-right>
                        <q-btn color="primary" icon-right="archive" label="Export to csv" no-caps
                            @click="exportToCsv" />
                    </template>
                </q-table>
            </q-card>
        </section>
        <q-separator />
        <q-card-section v-if="render">
            <VueApexCharts height="450" :options="chartOptions" :series="mapSeries" />
        </q-card-section>
    </div>
</template>

<script>
import VueApexCharts from "vue-apexcharts";
import { exportTable } from "@composables/ToCsv";

export default {
    name: 'CatalogacaoMensalPorUsuario',
    components: {
        VueApexCharts
    },
    data () {
        return {
            columns: [

                { name: 'Nome', align: 'center', label: 'Nome', field: 'name' },
                { name: 'Total', label: 'total', field: 'total' }

            ],
            mesMultiple: null,
            anoMultiple: null,
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
            const { data } = await axios.get(`/dashboard/catalogacao-mensal-por-usuario`);
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
                // renderiza
                this.render = data.success;
            }
            this.$q.loading.hide();
        }
    },
    methods: {
        exportToCsv () {
            exportTable(this.dataTable, this.columns)
        },
        getDataTable () {
            console.log('oisio')
        }
    }
}
</script>
<style scoped>

</style>
