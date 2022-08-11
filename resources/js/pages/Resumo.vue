<template>
  <div class="q-pa-md">
    <q-select
      filled
      v-model="item"
      use-input
      option-value="value"
      option-label="label"
      use-chips
      stack-value
      input-debounce="0"
      :options="selectOptions"
      class="q-mb-lg"
      @input="getData"
    />
    <q-card >
      <q-card-section >
        <VueApexCharts height="450" v-if="render" type="bar" :options="chartOptions" :series="series"></VueApexCharts>
      </q-card-section>
      <q-card-section>
        <q-table
          :title="title"
          :data="metadata"
          :columns="columns"
          row-key="id"
          separator="horizontal"
        />
      </q-card-section>
    </q-card>
  </div>
</template>
<script>// @ts-nocheck

import VueApexCharts from "vue-apexcharts";
import {
  QTable,
  QCard,
  QCardSection,
  QSeparator,
  QSelect,
  QChip
} from "quasar";

export default {
  name: "Resumo",
  components: {
    QTable,
    QCard,
    QChip,
    QSelect,
    QCardSection,
    QSeparator,
    VueApexCharts
  },
  data() {
    return {
      title: "",
      render: false,
      metadata: [],
      columns: [
        {
          name: "name",
          label: "Nome",
          field: "name"
        },
        {
          name: "total",
          label: "Total",
          field: "total"
        },
        {
          name: "month",
          label: "Mês",
          field: "month",
          required: false
        }
      ],
      item: { label: "Catalogação por usuário", value: "per_user" },
      selectOptions: [
        { label: "Tipos de mídias", value: "type_of_midia" },
        { label: "Catalogação por usuário", value: "per_user" },
        {
          label: "Catalogação por canal",
          value: "per_chanel"
        },
        { label: "Catalogação mensal por usuário", value: "user_montly" },
        { label: "Catalogação total mensal", value: "per_month" },
        { label: "Catalogação total mensal por canal", value: "canal_montly" },
        { label: "Conteúdos mais baixados", value: "qt_downloads" },
        { label: "Conteúdos mais acessados", value: "qt_access"}, 
        { label: "Tags mais procuradas", value: "searched_tags"},
        { label: "Aplicativos mais visualizados", value: "aplicativo_qt_access"},
        { label: "Registro de ocorrência formulário de contatos", value: "registro_mes_ocorrencia"},
        { label: "Conteúdos mais acessados nos últimos três meses", value: "acessados_ultimos_meses"},
        { label: "Catalogação BLOG", value: "wordpress_data" }
      ],
      chartOptions: {
        chart: {
          id: "vuechart-teste",
          height: 430,
          width: "100%",
          type: "bar"
        },
        title: {
          text: "hola",
          align: "center"
        },
        plotOptions: {
          bar: {
            horizontal: true
          }
        },
        dataLabels: {
          enabled: false
        },
        xaxis: {
          categories: []
        }
      },
      series: [{ name: "Quantidade", data: [] }]
    };
  },
  created() {
    this.getData();
  },
  methods: {
    async getData() {
      let url = `resumo?option=${this.item.value}`;
      let resp = await axios.get(url);
      console.log(resp)
      if (resp.data.success) {
        this.title = resp.data.metadata.title;
        this.metadata = resp.data.metadata.data;
        this.render = resp.data.metadata.render;
        if (this.render) {
          this.appendData(resp.data.metadata.series);
          this.createInfoGraf(resp.data.metadata.categories);
        }
      }
    },
    createInfoGraf(categories) {
      this.chartOptions = {
        ...this.chartOptions,
        ...{
          title: {
            text: this.title
          },
          xaxis: {
            categories
          }
        }
      };
    },
    appendData(data) {
      let arr = this.series.slice();
      arr[0].data = data;
      this.series = arr;
    }
  }
};
</script>
