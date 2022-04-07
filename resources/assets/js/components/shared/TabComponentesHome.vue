<template>
  <div>
    <q-tabs
      v-model="tab"
      dense
      align="justify"
      narrow-indicator
    >
      <q-tab
        name="tipos"
        label="Tipos de Conteúdos"
        class="bg-pink-9 text-white shadow-2"
      />

      <q-tab
        name="componentes"
        label="Componentes Curriculares"
        class="bg-deep-purple-9 text-white shadow-2"
      />
      <q-tab
        name="niveis"
        label="Níveis de Ensino"
        class="bg-cyan-10 text-white shadow-2"
      />
      <q-tab
        name="licencas"
        label="Licenças"
        class="bg-teal text-white shadow-2"
      />
      <q-tab
        icon="help"
        name="ajuda"
        label="Ajuda"
        class="bg-negative text-white shadow-2"
      />
    </q-tabs>

    <q-separator />

    <q-tab-panels
      v-model="tab"
      animated
    >
      <q-tab-panel name="tipos">
        <div class="flex justify-start">
          <div class="text-h6">Tipos de Conteúdos</div>
          <q-space></q-space>

        </div>
        <div class="flex justify-right q-mt-md q-gutter-md">
          <q-btn
            :class="'tipos'"
            size="md"
            color="pink-9"
            v-for="(tipo, i) in tipos"
            :key="`${i}-tipo`"
            @click="addTipo($event, tipo)"
          >
            {{ tipo.name }}

          </q-btn>
        </div>
      </q-tab-panel>

      <q-tab-panel name="licencas">
        <div class="flex justify-start">
          <div class="text-h6">Licenças</div>
          <q-space></q-space>

        </div>
        <div class="flex justify-right q-mt-md q-gutter-md">
          <q-btn
            class="licencas"
            size="md"
            color="teal"
            v-for="(licenca, i) in licencas"
            :key="`${i}-licenca`"
            @click="addLicenca($event, licenca)"
          >
            {{ licenca.name }}
          </q-btn>
        </div>
      </q-tab-panel>

      <q-tab-panel name="componentes">
        <div class="flex justify-start">
          <div class="text-h6">Componentes Curriculares</div>
          <q-space></q-space>

        </div>

        <div
          class="q-my-md"
          v-for="(component, i) in componentes"
          :key="`componente-${i}`"
          :index="component.id"
        >

          <q-expansion-item
            dense
            header-class="bg-deep-purple-9 text-white shadow-2"
            :label="component.name"
          >
            <div class="flex justify-right q-mt-md q-gutter-md">
              <q-btn
                class="componentes"
                size="md"
                color="deep-purple-9"
                v-for="(component, i) in component.componentes"
                :key="`componente-child-${i}`"
                @click="addComponente($event, component)"
                :label="component.name"
              />

            </div>
          </q-expansion-item>
        </div>
      </q-tab-panel>
      <q-tab-panel name="niveis">
        <div class="flex justify-start">
          <div class="text-h6">Outros Níveis e/ou Modalidades de Ensino</div>
          <q-space></q-space>

        </div>

        <div
          class="q-my-lg"
          v-for="(nivel, i) in niveis"
          :key="`nivel-${i}`"
          :index="nivel.id"
        >

          <q-expansion-item
            dense
            header-class="bg-cyan-10 text-white shadow-2"
            :label="nivel.name"
          >
            <div class="flex justify-right q-mt-md q-gutter-md">
              <q-btn
                class="niveis"
                size="md"
                color="cyan-10"
                v-for="(component, i) in nivel.componentes"
                :key="`nivel-child-${i}`"
                @click="addComponente($event, component)"
                :label="component.name"
              />
            </div>
          </q-expansion-item>
        </div>
      </q-tab-panel>

      <q-tab-panel name="ajuda">
        <div class="flex justify-start">
          <div class="text-h6">Ajuda para o uso da busca avançada</div>
          <q-space></q-space>

        </div>
        <div class="flex justify-right q-mt-md q-gutter-md">

        </div>
      </q-tab-panel>

    </q-tab-panels>
  </div>
</template>

<script>
import { mapState } from "vuex";
import { QTabPanels, QTabPanel } from "quasar";

export default {
  name: "TabComponentesHome",
  components: { QTabPanels, QTabPanel },
  data() {
    return {
      tab: "tipos",
      filtrosModel: {
        tipos: [],
        licencas: [],
        componentes: [],
      },
    };
  },
  computed: {
    ...mapState(["tipos", "licencas", "componentes", "niveis"]),
  },
  methods: {
    isLargestScreen() {
      let isLargest = this.$q.screen.gt.xs || this.$q.screen.gt.sm;
      return isLargest;
    },
    addTipo(ev, item) {
      const el = ev.target;
      if (this.filtrosModel.tipos.indexOf(item) === -1) {
        this.filtrosModel.tipos.push(item);
        this.emitValues();
      }
    },
    addLicenca(ev, item) {
      const el = ev.target;
      if (this.filtrosModel.licencas.indexOf(item) === -1) {
        this.filtrosModel.licencas.push(item);
        this.emitValues();
      }
    },
    addComponente(ev, item) {
      const el = ev.target;

      if (this.filtrosModel.componentes.indexOf(item) === -1) {
        this.filtrosModel.componentes.push(item);
        this.emitValues();
      }
    },
    emitValues() {
      this.$emit("setFiltros", this.filtrosModel);
    },
    clean() {
      this.filtrosModel.tipos = [];
      this.filtrosModel.licencas = [];
      this.filtrosModel.componentes = [];
      this.emitValues();
    },
  },
};
</script>
