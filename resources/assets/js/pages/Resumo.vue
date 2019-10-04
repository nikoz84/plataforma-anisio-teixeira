<template>
    <q-card class="q-mb-xl">
      <q-card-section>
        <h5 class="text-center" v-if="metadata && metadata.title">{{ metadata.title }}</h5> 
      </q-card-section>
      <q-card-section v-if="metadata && metadata.tables">
        <div class="row" v-for="(table, i) in metadata.tables" :key="i">
          <q-table :title="table.title"
            :data="table.data"
            :columns="table.columns"
            :row-key="'id'"
            class="q-mb-lg"
            >
          </q-table>
          <div class="" :id="`chart-${i}`">
            <!--  VueApexChart width="500" 
              type="bar" 
              :options="{chart:{id:`chart-${i}`}}" 
              :series="series"
              >
            </VueApexChart -->
          </div>
        </div>
      </q-card-section>
      <q-card-section v-if="metadata && metadata.blog && metadata.blog.title">
        <q-table :title="metadata.blog.title"
          :data="metadata.blog.data.posts"
          :columns="metadata.blog.columns"
          :row-key="'id'"
          >
         
        </q-table>
      </q-card-section>
    </q-card>
</template>
<script>
import VueApexChart from "vue-apexcharts";
import { QTable, QCard, QCardSection, QSeparator } from "quasar";

export default {
  name: "Resumo",
  components: {
    QCard,
    QCardSection,
    QSeparator,
    VueApexChart
  },
  data() {
    return {
      message: "hola mundo"
    };
  },
  mounted() {
    console.log("sss");
  }
};
</script>
