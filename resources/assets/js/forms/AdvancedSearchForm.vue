<template>
    <div>
        <q-dialog
            v-model="modalOpen"
            persistent
            :maximized="true"
            transition-show="slide-up"
            transition-hide="slide-down"
            >
            <q-card class="bg-grey-10 text-white">
                <q-bar>
                    <q-space />
                    <q-btn dense flat icon="close" v-close-popup >
                        <q-tooltip content-class="bg-white text-primary">Fechar</q-tooltip>
                    </q-btn>
                </q-bar>

                <q-card-section>
                    <div class="text-h6">Busca Avanzada</div>
                    <q-input color="teal" bottom-slots>
                        <template v-slot:after>
                            <q-btn color="primary" round dense icon="search" />
                        </template>
                    </q-input>
                </q-card-section>
                <q-card-section class="q-my-lg" v-if="canal.sidebar && canal.sidebar.tipos">
                    <div class="text-h6 text-orange">Tipos de Mídia</div>
                    <div class="q-gutter-sm">
                        <q-checkbox 
                                v-for="(tipo, i) in canal.sidebar.tipos" 
                                :key="`t-${i}`"
                                dark
                                v-model="tipos"
                                :val="tipo.id" 
                                :label="tipo.name" 
                                color="orange" 
                                />
                    </div>
                    <q-separator inset color="orange"></q-separator>
                </q-card-section>
                
                <q-card-section class="q-my-lg" v-if="canal.sidebar && canal.sidebar.licenses">
                    <div class="text-h6 text-positive">Licenças</div>
                    <div class="q-gutter-sm">
                        <q-checkbox dark
                                    v-for="(license, i) in canal.sidebar.licenses" 
                                    :key="`l-${i}`"
                                    v-model="licencas"
                                    :val="license.id" 
                                    :label="license.name" 
                                    color="positive" />
                    </div>
                    <q-separator inset color="positive"></q-separator>
                </q-card-section>
                <div v-if="canal.sidebar && canal.sidebar.components">
                    <q-card-section class="q-my-lg" v-for="(component, i) in canal.sidebar.components" :key="`c-${i}`" :index="component.id">
                        <div class="text-h6 text-negative">{{component.name}}</div>
                        <div class="q-gutter-sm" >
                            <q-checkbox  dark 
                                        v-for="(component, i) in component.components" 
                                        :key="`child-com-${i}`"
                                        v-model="componentes"
                                        :val="component.id" 
                                        :label="component.name"
                                        color="negative" />
                        </div>
                        <q-separator inset color="negative"></q-separator>
                    </q-card-section>
                </div>
                <div v-if="canal.sidebar && canal.sidebar.niveis">
                    <q-card-section class="q-my-lg" v-for="(nivel, n) in canal.sidebar.niveis" :key="`n-${n}`" :index="nivel.id">    
                        <div class="text-h6 text-teal ">{{nivel.name}}</div>
                        <div class="q-gutter-sm">
                            <q-checkbox dark 
                                    v-for="(component, i) in nivel.components" 
                                    :key="`child-com-${i}`"
                                    v-model="componentes"
                                    :val="component.id" 
                                    :label="component.name"
                                    color="teal" />
                        </div>
                        <q-separator inset color="teal"></q-separator>
                    </q-card-section>
                </div>
                
                <q-card-section class="row">
                {{tipos}}  - {{licencas}} - {{componentes}} 
                </q-card-section>
                <q-card-section class="row">
                {{canal.sidebar}}
                </q-card-section>
            </q-card>
        </q-dialog>
    </div>
</template>
<script>
import { mapState } from "vuex";
import {
  QList,
  QItem,
  QItemSection,
  QCheckbox,
  QCard,
  QCardSection,
  QSeparator
} from "quasar";

export default {
  name: "AdvancedSearchForm",
  props: ["open"],
  components: {
    QList,
    QItem,
    QItemSection,
    QCheckbox,
    QCard,
    QCardSection,
    QSeparator
  },
  data() {
    return {
      maximizedToggle: true,
      tipos: [],
      licencas: [],
      componentes: []
    };
  },
  computed: {
    ...mapState(["canal"]),
    modalOpen: {
      get() {
        return this.open;
      },
      set(val) {
        this.$emit("update:open", val);
      }
    }
  },
  methods: {}
};
</script>
