<template>
    <q-card>
        <q-card-section>
            <div class="text-dark text-h6">Filtros</div>
            <div class="q-gutter-md row items-start">
                <div style="min-width: 250px; max-width: 300px">
                    <q-select v-model="mesMultiple" multiple label-color="primary" :options="meses" use-chips
                        stack-label label="Filtrar por meses" />
                </div>
                <div style="min-width: 250px; max-width: 300px">
                    <q-select v-model="anoMultiple" multiple label-color="primary" :options="anos" use-chips stack-label
                        label="Filtrar por anos" />
                </div>
                <div style="min-width: 250px; max-width: 300px">
                    <q-select v-model="temaMultiple" multiple label-color="primary" :options="temas" use-chips
                        stack-label label="Tema ou Disciplina" />
                </div>
                <div style="min-width: 250px; max-width: 300px">
                    <q-select v-model="tipoConteudoMultiple" multiple label-color="primary" :options="tipoConteudo"
                        use-chips stack-label label="Tipo de conteúdo" />
                </div>
                <div style="min-width: 250px; max-width: 300px">
                    <q-select v-model="ordenarMultiple" label-color="primary" :options="ordenar" use-chips stack-label
                        label="Ordenar por:" />
                </div>
            </div>
        </q-card-section>
        <q-card-section>
            <q-table title="Contalogação Mensal" :data="data" :columns="columns" color="primary" row-key="name">
                <template v-slot:top-right>
                    <q-btn color="primary" icon-right="archive" label="Export to csv" no-caps @click="exportTable" />
                </template>
            </q-table>
        </q-card-section>
        <q-card-section>
            <VueApexCharts height="450" v-if="render" :options="chartOptions" :series="series" />
        </q-card-section>
    </q-card>
</template>

<script>
import { exportFile } from 'quasar';
import VueApexCharts from "vue-apexcharts";

export default {
    name: 'CatalogacaoMensal',
    components: {
        VueApexCharts
    },
    data () {
        return {
            columns: [

                { name: 'Titulo', align: 'center', label: 'Títulos', field: 'titulos' },
                { name: 'Descricao', label: 'Descrição', field: 'descricao' },
                { name: 'Author', label: 'Autor', field: 'autor' },
                { name: 'Q.Downloads', label: 'Q.Downloads', field: 'qt_downloads' },
                { name: 'Qt.Acessos', label: 'Qt.Acessos', field: 'qt_access' },
                { name: 'Dt.Criacao', label: 'Dt.Criação', field: 'created_at' }

            ],

            series: [{ name: "Quantidade", data: [] }],
            mesMultiple: null,
            anoMultiple: null,
            temaMultiple: null,
            tipoConteudoMultiple: null,
            ordenarMultiple: null,
            meses: [
                "Janeiro",
                "Fevereiro",
                "Março",
                "Abril",
                "Maio",
                "Junho",
                "Julho",
                "Agosto",
                "Setembro",
                "Outubro",
                "Novembro",
                "Dezembro",
            ],
            anos: ["2022", "2021", "2020", "2019", "2018"],
            temas: ["Matemática", "Física", "Química", "Sexualidade"],
            tipoConteudo: [
                "Videos",
                "Apresentações",
                "Áudios",
                "Aplicativos",
                "Games",
            ],
            ordenar: [
                "Mais baixados",
                "Mais visualizados",
                "Mais acessados",
                "Catalogado por usuário",
            ],
            chartOptions: {
                chart: {
                    id: "vuechart-teste",
                    height: 430,
                    width: "100%",
                    type: "bar",
                },
                title: {
                    text: "hola",
                    align: "center",
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                xaxis: {
                    categories: [],
                },
            },

        }
    }
}
</script>
<style scoped>

</style>
