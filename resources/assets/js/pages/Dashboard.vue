<template>
  <div class="q-gutter-md q-mt-sm q-pl-sm">
    <div class="q-mb-md">
      <div class="text-h5 title-page text-primary separatriz">Dashboard</div>
      <div class="separatriz-6"></div>
    </div>

    <div class="flex q-gutter-x-sm q-gutter-y-lg q-mt-md">
      <div>
        <ConteudosPorAno :isDashboard="true"></ConteudosPorAno>
      </div>
      <div>
        <AplicativosMaisVisualizados
          :isDashboard="true"
        ></AplicativosMaisVisualizados>
      </div>

      <div>
        <CatalogacaoMensalPorUsuario
          :isDashboard="true"
        ></CatalogacaoMensalPorUsuario>
      </div>
      <div>
        <CatalogacaoTotalMensal :isDashboard="true"></CatalogacaoTotalMensal>
      </div>
      <div>
        <CatalogacaoPorCanal :isDashboard="true"></CatalogacaoPorCanal>
      </div>
      <div>
        <ConteudosMaisBaixados :isDashboard="true"></ConteudosMaisBaixados>
      </div>
      <div>
        <ConteudosMaisAcessados :isDashboard="true"></ConteudosMaisAcessados>
      </div>
      <div>
        <TagsMaisProcuradas :isDashboard="true"></TagsMaisProcuradas>
      </div>
      <div>
        <TiposDeMidia :isDashboard="true"></TiposDeMidia>
      </div>
    </div>
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
  AplicativosMaisVisualizados,
  CatalogacaoPorCanal,
  CatalogacaoMensalPorUsuario,
  CatalogacaoTotalMensal,
  ConteudosMaisBaixados,
  TagsMaisProcuradas,
  TiposDeMidia,
} from "@components/dashboard";
import ConteudosMaisAcessados from "../components/dashboard/ConteudosMaisAcessados.vue";

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
    AplicativosMaisVisualizados,
    CatalogacaoPorCanal,
    CatalogacaoMensalPorUsuario,
    CatalogacaoTotalMensal,
    ConteudosMaisBaixados,
    ConteudosMaisAcessados,
    TagsMaisProcuradas,
    TiposDeMidia,
  },
};
</script>
<style scoped>
.text-h5 {
  line-height: 3rem;
}
</style>
