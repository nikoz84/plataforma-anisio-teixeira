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
      <q-tab name="tipos" label="Tipos" />
      <q-tab name="licencas" label="Licenças" />
      <q-tab name="componentes" label="Componentes Curriculares" />
      <q-tab name="niveis" label="Níveis de Ensino" />
    </q-tabs>

    <q-separator />

    <q-tab-panels v-model="tab" animated>
      <q-tab-panel name="tipos">
        <div class="flex justify-start">
          <div class="text-h6">Tipos de Mídias</div>
          <q-space></q-space>
          <q-btn
            icon-right="layers_clear"
            size="md"
            color="primary"
            class="text-dark"
            stack
            glossy
            @click="clean()"
            label="Limpar filtros"></q-btn>
        </div>
        <div class="flex justify-end q-mt-md q-gutter-md">
          <q-btn :class="'tipos'" size="sm" color="pink-9" v-for="(tipo, i) in tipos" :key="`${i}-tipo`" 
            @click="addTipo($event, tipo)">
            {{ tipo.name }}
          </q-btn>
        </div>
      </q-tab-panel>

      <q-tab-panel name="licencas">
        <div class="flex justify-start">
          <div class="text-h6">Licenças</div>
          <q-space></q-space>
          <q-btn
            icon-right="layers_clear"
            size="md"
            color="primary"
            class="text-dark"
            stack
            glossy
            @click="clean()"
            label="Limpar filtros"></q-btn>
        </div>
        <div class="flex justify-end q-mt-md q-gutter-md">
          <q-btn class="licencas" size="sm" color="teal" v-for="(licenca, i) in licencas" :key="`${i}-licenca`" 
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
          <q-btn
            icon-right="layers_clear"
            size="md"
            color="primary"
            class="text-dark"
            stack
            glossy
            @click="clean()"
            label="Limpar filtros"></q-btn>
        </div>
        
        <div class="q-my-md" v-for="(component, i) in componentes"
            :key="`componente-${i}`"
            :index="component.id"
            >
            <b v-text="component.name"></b>
            <q-separator></q-separator>
            <div class="flex justify-end q-mt-md q-gutter-md">
              <q-btn class="componentes" size="sm" color="deep-purple-9"
                  v-for="(component, i) in component.componentes"
                  :key="`componente-child-${i}`"
                  @click="addComponente($event, component)"
                  :label="component.name"
              />
            </div>
          </div>
      </q-tab-panel>
      <q-tab-panel name="niveis">
        <div class="flex justify-start">
          <div class="text-h6">Outros Níveis e/ou Modalidades de Ensino</div>
          <q-space></q-space>
          <q-btn
            icon-right="layers_clear"
            size="md"
            color="primary"
            class="text-dark"
            stack
            glossy
            @click="clean()"
            label="Limpar filtros"></q-btn>
        </div>
        
        <div class="q-my-lg" v-for="(nivel, i) in niveis"
            :key="`nivel-${i}`"
            :index="nivel.id"
            >
            <b v-text="nivel.name"></b>
            <q-separator class="q-mb-lg"></q-separator>
            <div class="flex justify-end q-mt-md q-gutter-md">
              <q-btn class="niveis" size="sm" color="cyan-10"
                  v-for="(component, i) in nivel.componentes"
                  :key="`nivel-child-${i}`"
                  @click="addComponente($event, component)"
                  :label="component.name"
              />
            </div>
          </div>
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
        tab: 'tipos',
        filtrosModel: {
          tipos: [],
          licencas: [],
          componentes: [],
        }
      }
    },
    computed: {
      ...mapState(["tipos", "licencas", "componentes", "niveis"]),
    },
    methods: {
      addTipo(ev, item) {
        const el = ev.target
        if(this.filtrosModel.tipos.indexOf(item) === -1) {
          this.filtrosModel.tipos.push(item);
          this.emitValues();
        }
      },
      addLicenca(ev, item) {
        const el = ev.target
        if(this.filtrosModel.licencas.indexOf(item) === -1) {
          this.filtrosModel.licencas.push(item);
          this.emitValues();
        }
      },
      addComponente(ev, item){
        const el = ev.target
        
        if(this.filtrosModel.componentes.indexOf(item) === -1) {
          this.filtrosModel.componentes.push(item);
          this.emitValues();
        }
      },
      emitValues() {
        this.$emit('setFiltros', this.filtrosModel);
      },
      clean(){
        this.filtrosModel.tipos = [];
        this.filtrosModel.licencas = [];
        this.filtrosModel.componentes = [];
        this.emitValues();
      }
    },
}
</script>
