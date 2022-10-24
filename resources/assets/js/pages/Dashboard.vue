<template>
  <div class="row q-pa-md q-gutter-md">
    <div class="q-mb-md">
      <div class="text-h5 title-page text-primary separatriz q-pb-md">
        Dashboard
      </div>
      <div class="separatriz-6"></div>
    </div>
    <div class="flex justify-center q-gutter-md">
      <ConteudosPorAno :isDashboard="true"></ConteudosPorAno>
    </div>
    <div class="flex justify-center q-gutter-md">
      <TiposDeMidia :isDashboard="true"></TiposDeMidia>
    </div>
    <div class="flex justify-center q-gutter-md">
      <TagsMaisProcuradas :isDashboard="true"></TagsMaisProcuradas>
    </div>
    <div class="flex justify-center q-gutter-md">
      <ConteudosMaisBaixados :isDashboard="true"></ConteudosMaisBaixados>
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
import {
  CardDashboard,
  ConteudosPorAno,
  TiposDeMidia,
  TagsMaisProcuradas,
  ConteudosMaisBaixados,

} from "@components/dashboard";

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
    ConteudosPorAno,
    TiposDeMidia,
    TagsMaisProcuradas,
    ConteudosMaisBaixados

  },
};
</script>