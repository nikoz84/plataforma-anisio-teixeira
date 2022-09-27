<template>
  <div class="q-pa-md">
    <div class="q-mb-md">
      <div class="text-h5 title-page text-primary separatriz q-pb-md">
        Dashboard
      </div>
      <div class="separatriz-6"></div>
    </div>

    <div class="row items-start q-gutter-md q-mb-xl">
      <card-dashboard v-for="(item, i) in dashboardData" :key="i" :data="item.data" :id="item.id" />
    </div>

    <div class="row items-start q-gutter-md q-mb-xl"></div>

  </div>
</template>
<script>
// @ts-nocheck

import VueApexCharts from "vue-apexcharts";
import {
  QTable,
  QCard,
  QCardSection,
  QSeparator,
  QSelect,
  QChip,
} from "quasar";
import { CardDashboard } from "@components/dashboard";

export default {
  name: "Dashboard",
  components: {
    QTable,
    QCard,
    QChip,
    QSelect,
    QCardSection,
    QSeparator,
    VueApexCharts,
    CardDashboard,
  },
  data () {
    return {
      title: "",
      render: false,
      dashboardData: null,
      metadata: [],
      columns: [
        {
          name: "name",
          label: "Nome",
          field: "name",
        },
        {
          name: "total",
          label: "Total",
          field: "total",
        },
        {
          name: "month",
          label: "Mês",
          field: "month",
          required: false,
        },
      ],
      item: { label: "Catalogação por usuário", value: "per_user" },
      selectOptions: [
        { label: "Tipos de mídias", value: "type_of_midia" },
        { label: "Catalogação por usuário", value: "per_user" },
        {
          label: "Catalogação por canal",
          value: "per_chanel",
        },
        { label: "Catalogação mensal por usuário", value: "user_montly" },
        { label: "Catalogação total mensal", value: "per_month" },
        { label: "Catalogação total mensal por canal", value: "canal_montly" },
        { label: "Conteúdos mais baixados", value: "qt_downloads" },
        { label: "Conteúdos mais acessados", value: "qt_access" },
        { label: "Tags mais procuradas", value: "searched_tags" },
        {
          label: "Aplicativos mais visualizados",
          value: "aplicativo_qt_access",
        },
        {
          label: "Registro de ocorrência formulário de contatos",
          value: "registro_mes_ocorrencia",
        },
        {
          label: "Conteúdos mais acessados nos últimos três meses",
          value: "acessados_ultimos_meses",
        },
        { label: "Catalogação BLOG", value: "wordpress_data" },
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
      series: [{ name: "Quantidade", data: [] }],
      anoMultiple: null,
      temaMultiple: null,
      anos: ["Google", "Facebook", "Twitter", "Apple", "Oracle"],
      temas: ["123", "456", "789", "000"],
    };
  },
  created () {
    this.getData();
    this.getDashboardData();
  },
  methods: {
    async getData () {
      let url = `resumo?option=${this.item.value}`;
      let resp = await axios.get(url);
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

    async getDashboardData () {
      let from = "01-01-2000";
      let to = "30-12-2022";
      let id = "";

      const { data } = await axios.get(
        `/dashboard?inicio=${from}&fim=${to}&category_id={id}`
      );
      console.log(data);
      if (data.success) {
        this.dashboardData = data.metadata;
      }
    },

    createInfoGraf (categories) {
      this.chartOptions = {
        ...this.chartOptions,
        ...{
          title: {
            text: this.title,
          },
          xaxis: {
            categories,
          },
        },
      };
    },
    appendData (data) {
      let arr = this.series.slice();
      arr[0].data = data;
      this.series = arr;
    },
  },
};
</script>
