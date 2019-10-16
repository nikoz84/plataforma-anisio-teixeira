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
    <q-card class="row">
      <q-card-section class="col-sm-6">
        <VueApexCharts type="bar" :options="chartOptions" :series="series"></VueApexCharts>
      </q-card-section>
      <q-card-section class="col-sm-6">
        <ul>
          <li v-for="(item, i) in metadata" :key="i">{{ item ? item.name : item.title }} - {{ item.total }}</li>
        </ul>
      </q-card-section>
    </q-card>
  </div>
</template>
<script>
import VueApexCharts from "vue-apexcharts";
import { QTable, QCard, QCardSection, QSeparator, QSelect } from "quasar";

export default {
  name: "Resumo",
  components: {
    QCard,
    QSelect,
    QCardSection,
    QSeparator,
    VueApexCharts
  },
  data() {
    return {
      item: { label: "Catalogação por usuário", value: "per_user" },
      selectOptions: [
        { label: "Catalogação por usuário", value: "per_user" },
        {
          label: "Catalogação canais Tv e Radio Anísio Teixeira",
          value: "tv_radio"
        },
        { label: "Catalogação mensal por usuário", value: "user_montly" },
        { label: "Catalogação total mensal", value: "per_month" },
        { label: "Catalogação total mensal por canal", value: "canal_montly" },
        { label: "Catalogação BLOG", value: "wordpress_data" }
      ],
      chartOptions: {
        chart: {
          id: "vuechart-teste",
          type: "bar"
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
      series: [{ data: [] }],
      metadata: null
    };
  },
  created() {
    this.getData();
  },
  methods: {
    async getData() {
      let url = `${this.$route.params.slug}?option=${this.item.value}`;
      let resp = await axios.get(url);

      if (resp.data.success) {
        this.chartOptions = {
          ...this.chartOptions,
          ...{
            xaxis: {
              categories: resp.data.metadata.names
            }
          }
        };

        this.appendData(resp.data.metadata.totals);
        this.metadata = resp.data.metadata.tables;
      }
    },
    appendData(data) {
      let arr = this.series.slice();
      arr[0].data = data;
      this.series = arr;
    }
  }
};
</script>
