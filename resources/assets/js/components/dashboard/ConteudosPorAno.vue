<template>
  <div class="q-pa-lg">
    <section>
      <q-card>
        <q-separator />
        <q-card-section>
          <div class="text-dark text-h6">Filtros</div>
          <div style="min-width: 250px; max-width: 300px">
            <q-select v-model="anoMultiple" multiple label-color="primary" :options="OptionsAnos" use-chips stack-label
              label="Filtrar por anos" />
          </div>
        </q-card-section>
        <q-table v-if="render" title="Conteúdos" :data="dataTable" :columns="columns" color="primary" row-key="name"
          :pagination="{ rowsPerPage: 20 }">
          <template v-slot:top-right>
            <q-btn color="primary" icon-right="archive" label="Export to csv" no-caps @click="exportToCsv" />
          </template>
        </q-table>
      </q-card>
    </section>
    <q-separator />
    <q-card-section v-if="render">
      <VueApexCharts height="450" type="bar" :options="chartOptions" :series="mapSeries" />
    </q-card-section>
  </div>
</template>

<script>
import { exportTable } from "@composables/ToCsv";
import VueApexCharts from "vue-apexcharts";

export default {
  name: "ConteudosPorAno",
  components: {
    VueApexCharts,
  },
  data () {
    return {
      OptionsAnos: [],
      anoMultiple: null,
      columns: [
        {
          name: "ano",
          align: "center",
          label: "Ano",
          field: "ano",
          sortable: true,
        },
        { name: "total", label: "Total", field: "total" },
      ],
      dataTable: [],
      mapSeries: [],
      render: false,
      // Inicio da configuração do gráfico
      chartOptions: {
        chart: {
          id: "vuechart-conteudos",
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
          positions: top,
        },
        xaxis: {
          categories: [],
        },
      },
    };
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
      const { data } = await axios.get(`/dashboard/conteudos-por-ano`);
      if (data.success) {
        this.dataTable = data.metadata;
        // define as as cetegorias com o spread operator (...)
        this.chartOptions = {
          ...this.chartOptions,
          ...{
            xaxis: {
              categories: data.metadata.map((item) => item.ano),
            },
          },
        };
        // define as series
        this.mapSeries = [
          {
            name: "Total",
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
