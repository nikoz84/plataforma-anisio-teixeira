<template>
  <div class="row items-start">
    <q-card class="my-card text-dark" style="" square>
      <!-- TÍTULO DOS DADOS -->
      <q-card-section>
        <div class="text-h6">
          {{ titulo }}
        </div>
      </q-card-section>
      <q-separator />
      <!-- ENTRADA DE DADOS -->
      <q-card-section v-if="id === 'conteudos-por-ano'">
        <span>
          <strong>Total de conteúdos:</strong>
          {{ cardContent.total }}
          <br />
          <strong>Ano:</strong>
          {{ cardContent.ano }}
          <br>
          <VueApexCharts height="450" :options="conteudosPorAnoOptions" :series="mapSeries" />
        </span>
      </q-card-section>
      <q-card-section v-else-if="id === 'catalogacao-por-canal'">
        <span>
          Quantidade: {{ cardContent.total }}
          <br />
          Nome canal: {{ cardContent.name }}
          <VueApexCharts height="450" :options="chartOptionsPorCanal" :series="mapSeriesPorCanal" />
        </span>
      </q-card-section>
      <q-card-section v-else-if="id === 'tags-mais-procuradas'">
        <span>
          Vezes buscada: {{ cardContent.name }}
          <br />
          Palavra-chave: {{ cardContent.searched }}
          <VueApexCharts height="450" :options="mapSeriesTagsProcuradas" :series="mapSeriesTagsProcuradas" />

        </span>
      </q-card-section>
      <q-card-section v-else-if="id === 'tipos-de-midia'">
        <span>
          Mídia: {{ cardContent.name }}
          <br />
          Total: {{ cardContent.total}}
          <VueApexCharts height="450" :options="chartOptionsTipos" :series="mapSeriesTipos" />
        </span>
      </q-card-section>
      <q-card-section v-else-if="id === 'aplicativos-mais-visualizados'">
        <span>
          Nome do aplicativo: {{ cardContent.name }}
          <br />
          Total: {{ cardContent.qt_access}}
          <VueApexCharts height="450" :options="chartOptionsMaisVizualizados" :series="chartOptionsMaisVizualizados" />

        </span>
      </q-card-section>
      <q-card-section v-else-if="id === 'conteudos-mais-acessados'">
        <span>
          Título: {{ cardContent.title}}
          <br />
          Total: {{ cardContent.qt_access}}
        </span>
        <VueApexCharts height="450" :options="chartOptionsMaisACessados" :series="mapSeriesMaisAcessados" />

      </q-card-section>
      <q-card-section v-else-if="id === 'conteudos-mais-baixados'">
        <span>
          Título: {{ cardContent.title}}
          <br />
          Total: {{ cardContent.qt_downloads}}
          <VueApexCharts height="450" :options="chartOptionsConteudosBaixados" :series="chartOptionsContudosBaixados" />

        </span>
      </q-card-section>
      <q-card-section v-else-if="id === 'catalogacao-mensal-por-usuario'">
        <span>
          Nome: {{ cardContent.name}}
          <br />
          Total: {{ cardContent.total}}
          <VueApexCharts height="450" :options="chartOptionsPorUsuario" :series="chartOptionsPorUsuario" />
        </span>
      </q-card-section>
      <q-card-section v-else-if="id === 'catalogacao-total-mensal'">
        <span>
          Mês: {{ cardContent.mes}}
          <br />
          Quantidade: {{ cardContent.quantidade}}
          <VueApexCharts height="450" :options="chartOptionsTotalMensal" :series="mapSeriesTotalMensal" />

        </span>
      </q-card-section>

      <!-- AÇÕES DOS DADOS -->
      <q-card-actions>
        <q-btn flat :to="`/admin/dashboard/${id}`" size="sm">Ver relatório completo</q-btn>
      </q-card-actions>
    </q-card>
  </div>
</template>

<script>
import VueApexCharts from "vue-apexcharts";
import { conteudosPorAnoOptions } from '@composables/ChartOptions'

export default {
  name: "CardDashboard",
  props: ["id", "titulo"],
  components: {
    VueApexCharts,
  },
  data () {
    return {
      cardContent: 'null',
      dataTable: [],
      mapSeries: [],
      mapSeriesPorCanal: [],
      mapSeriesTotalMensal: [],
      mapSeriesMaisAcessados: [],
      chartOptionsContudosBaixados: [],
      chartOptionsPorUsuario: [],
      mapSeriesTagsProcuradas: [],
      chartOptionsMaisVizualizados: [],
      mapSeriesTipos: [],

      render: false,
      conteudosPorAnoOptions: {
        plotOptions: {
          bar: {
            borderRadius: 4,
            horizontal: true,
          },
        },
        chart: {
          id: "vuechart-conteudos",
          height: 350,
          // width: "100%",
          type: "bar",
        },

        stroke: {
          curve: "smooth",
        },
        fill: {
          opacity: 0.8,
        },
        dataLabels: {
          enabled: false,
          positions: top,
        },
        xaxis: {
          categories: [],
        },
      },
      // Inicio da configuração do gráfico catalogação por canal
      chartOptionsPorCanal: {
        chart: {
          height: 350,
          type: "area",
          zoom: {
            enabled: false
          },
          labels: [],
        },
        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: 'smooth'
        },

        legend: {
          horizontalAlign: 'left'
        },

        xaxis: {
          name: "Catalogação por canal",
          categories: [],
        },
      },

      //Conteudos mais acessados
      chartOptionsMaisACessados: {
        chart: {
          height: 350,
          type: "bar",
        },

        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          },
        },//plotOptions
        dataLabels: {
          enabled: true,
        },
        xaxis: {
          categories: [],
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },

        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "$ " + val + " thousands"
            }
          }
        },
      },
      //Catalogacao total mensal
      // Inicio da configuração do gráfico
      chartOptionsTotalMensal: {
        chart: {
          height: 350,
          type: 'line'
        },

        dataLabels: {
          enabled: false,
        },
        xaxis: {
          categories: [],
        },
      },
      //Conteudos mais baixados
      chartOptionsConteudosBaixados: {
        chart: {
          type: "bar",
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

        stroke: {
          curve: 'smooth',
        },

      },
      //Inicia configuração do gráfico catalogação por usuario
      chartOptionsPorUsuario: {
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
            colors: ['#000']
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

      //Inicia configuração Tags mais procuradas
      mapSeriesTagsProcuradas: {
        chart: {
          height: 430,
          type: "line"
        },

        plotOptions: {
          bar: {
            horizontal: false,
            dataLabels: {
              position: 'top'
            },
          }
        },
        dataLabels: {
          enabled: true,
          offsetX: -6,
          style: {
            fontSize: '12px',
            colors: ['#363636']
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
      //Aplicativos mais vizualizados
      chartOptionsMaisVizualizados: {
        chart: {
          height: 430,
          type: "line"
        },

        plotOptions: {
          bar: {
            horizontal: false,
            dataLabels: {
              position: 'top'
            },
          }
        },
        dataLabels: {
          enabled: true,
          offsetX: -6,
          style: {
            fontSize: '12px',
            colors: ['#363636']
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
      chartOptionsTipos: {
        plotOptions: {
          bar: {
            borderRadius: 4,
            horizontal: true,
          },
        },
        chart: {
          id: "vuechart-conteudos",
          height: 350,
          // width: "100%",
          type: "bar",
        },

        stroke: {
          curve: "smooth",
        },
        fill: {
          opacity: 0.8,
        },
        dataLabels: {
          enabled: false,
          positions: top,
        },
        xaxis: {
          categories: [],
        },
      }
    }
  },
  mounted () {
    this.getDataTable();
  },

  methods: {

    async getDataTable () {
      this.$q.loading.show();
      const { data } = await axios.get(`/dashboard/${this.id}`)
      if (data.success) {
        // define as as cetegorias com o spread operator (...)
        const [first] = data.metadata
        this.cardContent = first



        this.conteudosPorAnoOptions = {
          ...this.conteudosPorAnoOptions,
          ...{
            xaxis: {
              categories: data.metadata.map((item) => item.ano),
            },
          },
        };
        // define as series conteudo por ano
        this.mapSeries = [
          {
            name: "Total",
            data: data.metadata.map((item) => item.total),
          },
        ];
        //

        //Catalogacao por canal
        this.chartOptionsPorCanal = {
          ...this.chartOptionsPorCanal,
          ...{
            xaxis: {
              categories: data.metadata.map((item) => item.name),
            },
          },
        };
        // define as series por Canal
        this.mapSeriesPorCanal = [
          {
            name: "Total",
            data: data.metadata.map((item) => item.total),
          },
        ];

        //Conteudos mais baixados
        this.chartOptionsConteudosBaixados = {
          ...this.chartOptionsConteudosBaixados,
          ...{
            xaxis: {
              categories: data.metadata.map((item) => item.title),
            },
          },
        };
        this.chartOptionsContudosBaixados = [
          {
            name: "Download",
            data: data.metadata.map((item) => item.qt_downloads),
          },
        ];

        //Conteudos mais acessados

        this.chartOptionsMaisACessados = {
          ...this.chartOptionsMaisACessados,
          ...{
            xaxis: {
              categories: data.metadata.map((item) => item.title),
            },
          },
        };
        // define as series
        this.mapSeriesMaisAcessados = [
          {
            name: "Download",
            data: data.metadata.map((item) => item.qt_access),
          },
        ];

        //Catalogação total mensal
        this.chartOptionsTotalMensal = {
          ...this.chartOptionsTotalMensal,
          ...{
            xaxis: {
              categories: data.metadata.map((item) => item.mes),
            },
          },
        };
        // define as series
        this.mapSeriesTotalMensal = [
          {
            name: "Download",
            data: data.metadata.map((item) => item.quantidade),
          },
        ];
        //Catalogação por usuario
        this.chartOptionsPorUsuario = {
          ...this.chartOptionsPorUsuario,
          ...{
            xaxis: {
              categories: data.metadata.map((item) => item.name),
            },
          },
        };
        // define as series
        this.chartOptionsPorUsuario = [
          {
            name: "Total",
            data: data.metadata.map((item) => item.total),
          },
        ];

        //Tag mais procuradas

        //Catalogação total mensal
        this.mapSeriesTagsProcuradas = {
          ...this.mapSeriesTagsProcuradas,
          ...{
            xaxis: {
              categories: data.metadata.map((item) => item.name),
            },
          },
        };
        // define as series
        this.mapSeriesTagsProcuradas = [
          {
            name: "searched",
            data: data.metadata.map((item) => item.searched),
          },
        ];

        //Catalogação por usuario
        this.chartOptionsPorUsuario = {
          ...this.chartOptionsPorUsuario,
          ...{
            xaxis: {
              categories: data.metadata.map((item) => item.name),
            },
          },
        };
        // define as series
        this.chartOptionsPorUsuario = [
          {
            name: "Total",
            data: data.metadata.map((item) => item.total),
          },
        ];

        //Aplicativos mais visualizados

        this.chartOptionsMaisVizualizados = {
          ...this.chartOptionsMaisVizualizados,
          ...{
            xaxis: {
              categories: data.metadata.map((item) => item.name),
            },
          },
        };
        // define as series
        this.chartOptionsMaisVizualizados = [
          {
            name: "Total",
            data: data.metadata.map((item) => item.qt_access),
          },
        ];

        this.chartOptionsTipos = {
          ...this.chartOptionsTipos,
          ...{
            xaxis: {
              categories: data.metadata.map((item) => item.name),
            },
          },
        };
        // define as series
        this.mapSeriesTipos = [
          {
            name: "Total",
            data: data.metadata.map((item) => item.total),
          },
        ];

        // renderiza
        this.render = data.success;
      }
      this.$q.loading.hide();
    }

  },

};
</script>
<style scoped>
.my-card {
  width: 450px;
  max-width: 450px;
}
</style>
