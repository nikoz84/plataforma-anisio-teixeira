<template>
  <q-card>
    <q-card-section v-if="!isDashboard">
      <div class="q-mb-md">
        <div class="text-h5 title-page text-primary separatriz q-mb-xm">
          Conteúdos por Ano
        </div>
        <div class="separatriz-6"></div>
      </div>
      <div class="text-dark text-h6">Filtros</div>
      <div class="row q-gutter-md">
        <q-select
          class="col"
          dense
          clearable
          v-model="ano"
          label-color="primary"
          :options="filtroAnos"
          label="Filtrar por anos"
        />
        <q-select
          class="col"
          dense
          clearable
          v-model="ordenarPor"
          label-color="primary"
          :options="filtroOrdenarPor"
          option-value="id"
          option-label="nome"
          stack-label
          emit-value
          map-options
          label="Ordenar por"
        />
        <q-btn
          class="col"
          color="primary"
          label="Pesquisar"
          @click="getDataTable"
        />
        <q-btn class="col" color="primary" :to="buttonRedirect.url">
          {{ buttonRedirect.label }}
        </q-btn>
      </div>
    </q-card-section>

    <q-card-section
      v-if="!isDashboard"
      horizontal
      class="q-ma-sm"
      style="border: 1px solid rgba(0, 0, 0, 0.12); min-height: 650px"
    >
      <q-card-section>
        <q-table
          flat
          dense
          :data="dataTable"
          :columns="columns"
          color="primary"
          row-key="name"
          :pagination="{ rowsPerPage: 20 }"
        >
        </q-table>
        <q-btn
          color="primary"
          icon-right="archive"
          label="Exportar em .csv"
          no-caps
          @click="exportToCsv"
        />
      </q-card-section>
      <q-separator vertical />
      <q-card-section class="q-table">
        <VueApexCharts
          height="100%"
          :options="chartOptions"
          :series="mapSeries"
        />
      </q-card-section>
    </q-card-section>

    <q-card-section v-if="isDashboard">
      <VueApexCharts height="450" :options="chartOptions" :series="mapSeries" />
    </q-card-section>
    <q-card-actions v-if="isDashboard">
      <q-btn
        color="primary"
        class="full-width"
        :to="buttonRedirect.url"
        size="sm"
      >
        {{ buttonRedirect.label }}
      </q-btn>
    </q-card-actions>
  </q-card>
</template>

<script>
import { exportTable } from "@composables/ToCsv";
import VueApexCharts from "vue-apexcharts";

export default {
  name: "ConteudosPorAno",
  components: {
    VueApexCharts,
  },
  props: ["isDashboard"],
  data() {
    return {
      filtroAnos: [],
      filtroOrdenarPor: [],
      ano: null,
      ordenarPor: null,
      columns: [
        {
          name: "ano",
          align: "left",
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
          animations: {
            enabled: true,
            easing: "easeinout",
            speed: 800,
            animateGradually: {
              enabled: true,
              delay: 200,
            },
            dynamicAnimation: {
              enabled: true,
              speed: 350,
            },
          },
        },
        title: {
          text: "Conteúdos por ano",
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
    buttonRedirect() {
      return this.isDashboard
        ? {
            label: "Ver relatório completo",
            url: "/admin/dashboard/conteudos-por-ano",
          }
        : { label: "Voltar", url: "/admin/dashboard/listar" };
    },
  },
  created() {
    this.getDataTable();
    this.getFiltros();
  },

  methods: {
    exportToCsv() {
      exportTable(this.dataTable, this.columns);
    },

    async getDataTable() {
      this.render = false;
      this.$q.loading.show();
      const { data } = await axios.get(`/dashboard/conteudos-por-ano`, {
        params: {
          ano: this.ano,
          ordenarPor: this.ordenarPor,
        },
        
      });
      this.prepararDados(data);
      this.$q.loading.hide();
    },
    async prepararDados(data) {
      if (data.success) {
        this.dataTable = data.metadata;
        this.chartOptions = {
          ...this.chartOptions,
          ...{
            xaxis: {
              categories: data.metadata.map((item) => item.ano),
              title: {
                text: "(quantidade)",
                offsetX: 0,
                offsetY: 0,
                style: {
                  color: undefined,
                  fontSize: "12px",
                  fontFamily: "Helvetica, Arial, sans-serif",
                  fontWeight: 100,
                  cssClass: "apexcharts-xaxis-title",
                },
              },
            },
            yaxis: {
              title: {
                text: "(ano)",
                offsetX: 0,
                offsetY: 0,
                style: {
                  color: undefined,
                  fontSize: "12px",
                  fontFamily: "Helvetica, Arial, sans-serif",
                  fontWeight: 400,
                  cssClass: "apexcharts-yaxis-title",
                },
              },
              labels: {
                rotate: 0,
              },
            },
          },
        };
        this.mapSeries = [
          {
            name: "Total",
            data: data.metadata.map((item) => item.total),
          },
        ];
      }
      this.render = true;
    },

    async getFiltros () {


      const { data } = await axios.get(`/dashboard/filtros/conteudos-por-ano`);

      if (data.success) {
        this.filtroAnos = data.metadata.anos;
        this.filtroOrdenarPor = data.metadata.ordenarPor;
      }
    },
  },
};
</script>
<style scoped>
.text-h5 {
  line-height: 3rem;
}
</style>
