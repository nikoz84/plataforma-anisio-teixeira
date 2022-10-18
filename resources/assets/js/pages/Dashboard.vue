<template>
  <div class="q-pa-md">
    <div class="q-mb-md">
      <div class="text-h5 title-page text-primary separatriz q-pb-md">
        Dashboard
      </div>
      <div class="separatriz-6"></div>
    </div>

    <div class="row items-start q-gutter-md q-mb-xl">
<<<<<<< HEAD
<<<<<<< HEAD
      <card-dashboard
        v-for="(item, i) in dashboardData"
        :key="i"
        :data="item.data"
        :id="item.id"
      />
       <VueApexCharts
          height="450"
          v-if="render"
          type="bar"
          :options="chartOptions"
          :series="series"
        ></VueApexCharts>
=======
      <card-dashboard v-for="(item, i) in dashboardData" :key="i" :data="item.data" :id="item.id" />

>>>>>>> feat-02
=======
      <card-dashboard v-for="(card, i) in cards" :key="i" :titulo="card.titulo" :id="card.id" />
>>>>>>> feat-02
    </div>

    <div class="row items-start q-gutter-md q-mb-xl"></div>

    <q-card>

      <q-separator />


    </q-card>

  </div>
</template>
<script>
// @ts-nocheck

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
    CardDashboard
  },
  data () {
    return {
      title: "",
      render: false,
      cards: null,
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


    };
  },
  created () {
    this.getData();
    this.getCards();
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

    async getCards () {

      const { data } = await axios.get('/dashboard');

      if (data?.success) {
        this.cards = data.metadata;
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
