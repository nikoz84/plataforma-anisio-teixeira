<template>
  <div class="q-ml-sm q-mt-sm">
    <div class="q-mb-md">
      <div class="text-h5 title-page text-primary separatriz">Dashboard</div>
      <div class="separatriz-6"></div>
    </div>

    <div class="q-gutter-sm row">
      <div class="col-4">
        <ConteudosPorAno :isDashboard="true"></ConteudosPorAno>
      </div>
      <div class="col-3">
        <AplicativosMaisVisualizados
          :isDashboard="true"
        ></AplicativosMaisVisualizados>
      </div>
      <div class="col-4">
        <CatalogacaoMensalPorUsuario
          :isDashboard="true"
        ></CatalogacaoMensalPorUsuario>
      </div>
      <div class="col-4">
        <CatalogacaoTotalMensal :isDashboard="true"></CatalogacaoTotalMensal>
      </div>
      <div class="col-3">
        <CatalogacaoPorCanal :isDashboard="true"></CatalogacaoPorCanal>
      </div>
      <div class="col-4">
        <ConteudosMaisBaixados :isDashboard="true"></ConteudosMaisBaixados>
      </div>
      <div class="col-4">
        <ConteudosMaisAcessados :isDashboard="true"></ConteudosMaisAcessados>
      </div>
      <div class="col-3">
        <TagsMaisProcuradas :isDashboard="true"></TagsMaisProcuradas>
      </div>
      <div class="col-4">
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
