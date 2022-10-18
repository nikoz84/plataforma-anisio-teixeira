<template>
  <div class="q-pa-md">
    <div class="q-mb-md">
      <div class="text-h5 title-page text-primary separatriz q-pb-md">
        Dashboard
      </div>
      <div class="separatriz-6"></div>
    </div>
    <div class="row items-start q-gutter-md q-mb-xl">
      <card-dashboard v-for="(card, i) in cards" :key="i" :titulo="card.titulo" :id="card.id" />
    </div>
    <div class="row items-start q-gutter-md q-mb-xl"></div>
    <q-card>
      <q-separator />
    </q-card>
  </div>
</template>
<script>
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
    this.getCards();
  },
  methods: {
    async getCards () {
      const { data } = await axios.get('/dashboard');
      if (data?.success) {
        this.cards = data.metadata;
      }
    }
  },
};
</script>
