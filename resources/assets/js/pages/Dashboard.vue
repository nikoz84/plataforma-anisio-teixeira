<template>
  <div class="q-pa-md">
    <div class="q-mb-md">
      <div class="text-h5 title-page text-primary separatriz q-pb-md">
        Dashboard
      </div>
      <div class="separatriz-6"></div>
    </div>
    <div class="flex justify-center q-gutter-md">
      <ConteudosPorAno :isDashboard="true"></ConteudosPorAno>
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
import { CardDashboard, ConteudosPorAno } from "@components/dashboard";


export default {
  name: "Dashboard",
  components: {
    QTable,
    QCard,
    QChip,
    QSelect,
    QCardSection,
    QSeparator,
    CardDashboard,
    ConteudosPorAno

  },
};
</script>
