<template>
  <q-card>
    <q-card-section v-if="!isDashboard" class="qmb-md">
      <div class="q-mb-md">
        <div class="text-h5 title-page text-primary separatriz q-mb-xm">
          Catalogação Total Mensal
        </div>
        <div class="separatriz-6"></div>
      </div>
      <div class="text-dark text-h6">Filtros</div>
      <div class="q-gutter-md row items-start">
        <div style="min-width: 150px; max-width: 200px">
        <q-input v-model="start" filled type="date" clearable />
    </div>
    <div style="min-width: 150px; max-width: 200px">
        <q-input v-model="end" filled type="date" clearable />
        </div>
        <div style="min-width: 150px; max-width: 200px">
          <q-btn class="col" 
          color="primary" 
          label="Pesquisar" 
          @click="getDataTable" />
                    <q-btn class="col" color="secondary" :to="buttonRedirect.url">
                        {{ buttonRedirect.label }}
                    </q-btn>
        </div>
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

    <q-card-section v-if="isDashboard" style="min-height: 450px">
      <VueApexCharts
        height="100%"
        :options="chartOptions"
        :series="mapSeries"
      />
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
  props: ["isDashboard"],
  data() {
    return {
      columns: [
        {
          name: "mes",
          align: "left",
          label: "Mês",
          field: "mes",
          sortable: true,
          width: "100%",
        },
        {
          name: "Quantidade",
          label: "Quantidade",
          field: "quantidade",
        },
      ],
      dataTable: [],
      mapSeries: [],
      render: false,
      start:'',
      end:'',
      filtroOrdenarPor: [],
      ordenarPor:null,
      // Inicio da configuração do gráfico
      chartOptions: {
        chart: {
          height: 350,
          type: "area",
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
    };
  },
  computed: {
      buttonRedirect () {
          return this.isDashboard ?
              { label: 'Ver relatório completo', url: '/admin/dashboard/catalogacao-total-mensal' } :
              { label: 'Voltar', url: '/admin/dashboard/listar' }
      }
  },
  created() {
    this.getDataTable();
    this.getFiltros();
  },
  methods: {
    exportToCsv() {
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
        // define as as cetegorias com o spread operator (...)
        this.chartOptions = {
          ...this.chartOptions,
          ...{
            chart: {
              toolbar: {
                tools: {
                  pan: false,
                  selection: false,
                  zoom: false,
                  zoomin: false,
                  zoomout: false,
                  reset: false,
                },

              },
            },
            xaxis: {
              categories: data.metadata.map((item) => item.mes),
              title: {
                text: "(mês)",
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
              labels: {
                rotate: -45,
                formatter: function (value) {
                  if (value == 1) {
                    value = "JAN";
                  }
                  if (value == 2) {
                    value = "FEV";
                  }
                  if (value == 3) {
                    value = "MAR";
                  }
                  if (value == 4) {
                    value = "ABR";
                  }
                  if (value == 5) {
                    value = "MAI";
                  }
                  if (value == 6) {
                    value = "JUN";
                  }
                  if (value == 7) {
                    value = "JUL";
                  }
                  if (value == 8) {
                    value = "AGO";
                  }
                  if (value == 9) {
                    value = "SET";
                  }
                  if (value == 10) {
                    value = "OUT";
                  }
                  if (value == 11) {
                    value = "NOV";
                  }
                  if (value == 12) {
                    value = "DEZ";
                  }
                  return value;
                },
              },
            },
            yaxis: {
              title: {
                text: "(quantidade)",
                offsetX: 0,
                offsetY: 0,
                style: {
                  color: undefined,
                  fontSize: "12px",
                  fontFamily: "Helvetica, Arial, sans-serif",
                  fontWeight: 400,
                  cssClass: "apexcharts-xaxis-title",
                },
              },
              labels: {
                rotate: 270,
              },
            },
          },
        };
        // define as series
        this.mapSeries = [
          {
            name: "Catalogados",
            data: data.metadata.map((item) => item.quantidade),
          },
        ];
        
        this.render = true;
    }
    },
    async getFiltros () {
        const { data } = await axios.get(`/dashboard/filtros/catalogacao-total-mensal`);

        if (data.success) {
            this.filtroOrdenarPor = data.metadata.ordenarPor;
        }
    }
}
};
</script>
<style scoped>
.text-h5 {
  line-height: 3rem;
}
</style>
