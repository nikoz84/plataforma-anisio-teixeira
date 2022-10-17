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
          <VueApexCharts height="450" type="bar" :options="chartOptions" :series="mapSeries" />
        </span>
      </q-card-section>
      <q-card-section v-else-if="id === 'catalogacao-por-canal'">
        <span>
          Quantidade: {{ cardContent.total }}
          <br />
          Nome canal: {{ cardContent.name }}
          <VueApexCharts height="450" type="bar" :options="chartOptionsPorCanal" :series="mapSeriesPorCanal" />

        </span>
      </q-card-section>
      <q-card-section v-else-if="id === 'tags-mais-procuradas'">
        <span>
          Vezes buscada: {{ cardContent.name }}
          <br />
          Palavra-chave: {{ cardContent.searched }}
        </span>
      </q-card-section>
      <q-card-section v-else-if="id === 'tipos-de-midia'">
        <span>
          Nome da mída: {{ cardContent.name }}
          <br />
          Total: {{ cardContent.total}}
        </span>
      </q-card-section>
      <q-card-section v-else-if="id === 'aplicativos-mais-visualizados'">
        <span>
          Nome do aplicativo: {{ cardContent.name }}
          <br />
          Total: {{ cardContent.qt_access}}
        </span>
      </q-card-section>
      <q-card-section v-else-if="id === 'conteudos-mais-acessados'">
        <span>
          Título: {{ cardContent.title}}
          <br />
          Total: {{ cardContent.qt_access}}
        </span>
        <VueApexCharts height="450" type="bar" :options="chartOptionsMaisACessados" :series="mapSeriesMaisAcessados" />

      </q-card-section>
      <q-card-section v-else-if="id === 'conteudos-mais-baixados'">
        <span>
          Título: {{ cardContent.title}}
          <br />
          Total: {{ cardContent.qt_downloads}}
          <VueApexCharts height="450" type="line" :options="chartOptionsConteudosMaisBaixados"
            :series="mapSeriesConteudosMaisBaixados" />

        </span>
      </q-card-section>
      <q-card-section v-else-if="id === 'catalogacao-mensal-por-usuario'">
        <span>
          Nome: {{ cardContent.name}}
          <br />
          Total: {{ cardContent.total}}
        </span>
      </q-card-section>
      <q-card-section v-else-if="id === 'catalogacao-total-mensal'">
        <span>
          Mês: {{ cardContent.mes}}
          <br />
          Quantidade: {{ cardContent.quantidade}}
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
      mapSeriesPorCanal: [],
      mapSeriesMaisAcessados: [],

      render: false,

      // Inicio da configuração do gráfico conteudos por ano
      chartOptions: {
        plotOptions: {
          bar: {
            borderRadius: 4,
            horizontal: true,
          }
        },
        chart: {
          id: "vuechart-conteudos",
          height: 350,
          // width: "100%",
          type: "bar",
        },

        stroke: {
          curve: 'smooth',
        },
        fill: {
          opacity: 0.8
        },
        dataLabels: {
          enabled: false,
          positions: top,
        },
        xaxis: {
          categories: [],
        }
      },
      // Inicio da configuração do gráfico catalogação por canal
      chartOptionsPorCanal: {
        chart: {
          height: 350,
          type: "area",
          zoom: {
            enabled: false
          },
        },
        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: 'straight'
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
      chartOptionsMaisAcessados: {
        chart: {
          height: 430,
          type: "bar",
        },
        title: {
          text: "Conteúdos mais acessados",
          align: "center",
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
      //
      //Conteudos mais baixados
      chartOptionsConteudosMaisBaixados: {
        chart: {
          height: 430,
          width: "100%",
          type: "line",
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
        stroke: {
          curve: 'smooth',
        },

      },

    }
  },
  created () {
    this.getDataFromId();
    this.getDataTable();
  },

  methods: {
    async getDataFromId () {
      console.log(this.id)
      const { data } = await axios.get(`/dashboard/${this.id}`)
      if (data.success) {
        const [first] = data.metadata
        console.log(first)
        this.cardContent = first
      }
    },

    async getDataTable () {
      this.$q.loading.show();
      const { data } = await axios.get(`/dashboard/${this.id}`)
      if (data.success) {
        // define as as cetegorias com o spread operator (...)

        this.chartOptions = {
          ...this.chartOptions,
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
        this.chartOptionsConteudosMaisBaixados = {
          ...this.chartOptionsConteudosMaisBaixados,
          ...{
            xaxis: {
              categories: data.metadata.map((item) => item.title),
            },
          },
        };
        this.mapSeriesConteudosMaisBaixados = [
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
