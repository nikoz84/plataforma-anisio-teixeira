<template>
    <div class="q-pa-lg">
        <section>
            <q-card>
                <q-separator />
                <q-card-section>
                    <div class="text-dark text-h6">Filtros</div>

                </q-card-section>
                <q-table title="Conteúdos" :data="dataTable" :columns="columns" color="primary" row-key="name"
                    :pagination="{rowsPerPage: 20}">
                    <template v-slot:top-right>
                        <q-btn color="primary" icon-right="archive" label="Export to csv" no-caps
                            @click="exportToCsv" />
                    </template>
                </q-table>
            </q-card>
        </section>
        <q-separator />
        <q-card-section>
            <VueApexCharts height="450" type="bar" :render="render" :options="chartOptions" />
        </q-card-section>
    </div>
</template>

<script>
import { exportTable } from '@composables/ToCsv';
import VueApexCharts from "vue-apexcharts";


export default {
    name: 'ConteudosPorAno',
    components: {
        VueApexCharts
    },
    data () {
        return {
            columns: [
                { name: 'ano', align: 'center', label: 'Ano', field: 'ano', sortable: true, },
                { name: 'total', label: 'Total', field: 'total' },
            ],
            dataTable: [],
            mapSeries: [],
            render: false,
            chartOptions: {
                chart: {
                    id: "vuechart-teste",
                    height: 430,
                    width: "100%",
                    type: "bar",
                },
                title: {
                    text: "Conteúdos por ano",
                    align: "center",
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                xaxis: {
                    categories: [],
                },
                series: null
            },

        }
    },
    created () {
        this.getDataTable();
    },
    methods: {
        exportToCsv () {
            exportTable(this.dataTable, this.columns)
        },
        async getDataTable () {
            const { data } = await axios.get(`/dashboard/conteudos-por-ano`)
            if (data.success) {
                this.dataTable = data.metadata
                this.chartOptions.xaxis.categories = data.metadata.map(item => item.ano)
                //this.chartOptions.series = [{ name: "Quantidade", data: data.metadata.map(item => item.total) }]
                //this.render = data.success
                console.log(this.mapSeries, this.chartOptions)
            }
        }
    }
}
</script>
<style scoped>

</style>
