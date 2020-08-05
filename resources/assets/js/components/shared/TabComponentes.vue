<template>
  <div>
    <q-tabs
      v-model="tab"
      dense
      class="text-grey"
      active-color="primary"
      indicator-color="primary"
      align="justify"
      narrow-indicator
    >
      <q-tab name="mails" label="Mails" />
      <q-tab name="alarms" label="Alarms" />
      <q-tab name="movies" label="Movies" />
    </q-tabs>

    <q-separator />

    <q-tab-panels v-model="tab" animated>
      <q-tab-panel name="tipos">
        <div class="text-h6">Tipos</div>
        Lorem ipsum dolor sit amet consectetur adipisicing elit.
      </q-tab-panel>

      <q-tab-panel name="licencas">
        <div class="text-h6">Licenças</div>
        Lorem ipsum dolor sit amet consectetur adipisicing elit.
      </q-tab-panel>

      <q-tab-panel name="componentes">
        <div class="text-h6">Componentes Curriculares</div>
        Lorem ipsum dolor sit amet consectetur adipisicing elit.
      </q-tab-panel>
      <q-tab-panel name="niveis">
        <div class="text-h6">Niveis de Ensino</div>
        Lorem ipsum dolor sit amet consectetur adipisicing elit.
      </q-tab-panel>
    </q-tab-panels>
  </div>
</template>

<script>
import {mapState} from 'vuex';
import { QTabPanels, QTabPanel } from "quasar"

export default {
    name: "TabComponentes",
    components: { QTabPanels, QTabPanel},
    data() {
      return {
        tab: 'movies'
      }
    },
    computed: {
      ...mapState(["tipos", "licencas", "componentes", "niveis"]),
    },
}
</script>
