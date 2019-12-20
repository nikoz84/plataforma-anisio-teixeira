<template>
    <div>
        <q-btn label="Ferramentas" size="sm" color="primary" @click="dialog = true" />
        <q-dialog
            v-model="dialog"
            persistent
            :maximized="maximizedToggle"
            transition-show="slide-up"
            transition-hide="slide-down"
            >
            <q-card class="bg-primary text-white">
                <q-bar>
                <q-space />

                <q-btn dense flat icon="minimize" @click="maximizedToggle = false" :disable="!maximizedToggle">
                    <q-tooltip v-if="maximizedToggle" content-class="bg-white text-primary">Minimize</q-tooltip>
                </q-btn>
                <q-btn dense flat icon="crop_square" @click="maximizedToggle = true" :disable="maximizedToggle">
                    <q-tooltip v-if="!maximizedToggle" content-class="bg-white text-primary">Maximize</q-tooltip>
                </q-btn>
                <q-btn dense flat icon="close" v-close-popup>
                    <q-tooltip content-class="bg-white text-primary">Close</q-tooltip>
                </q-btn>
                </q-bar>

                <q-card-section class="row">
                    <div class="text-h6">Busca Avanzada</div>
                </q-card-section>
                <q-card-section class="row" v-if="canal.sidebar && canal.sidebar.tipos">
                    <div class="col-sm-3">
                        <div class="text-h6">Tipos de Mídia</div>
                        <q-list>
                            <q-item v-for="(tipo, i) in canal.sidebar.tipos" :key="`t-${i}`">
                                <q-item-section>
                                    <q-checkbox v-model="tipos"
                                            :val="tipo.id" 
                                            :label="tipo.name" 
                                            color="orange" />
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </div>
                    <div class="col-sm-3">
                        <div class="text-h6">Licenças</div>
                        <q-list>
                            <q-item v-for="(license, i) in canal.sidebar.licenses" :key="`l-${i}`">
                                <q-item-section>
                                    <q-checkbox v-model="licencas"
                                            :val="license.id" 
                                            :label="license.name" 
                                            color="orange" />
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </div>
                    <div class="col-sm-3">
                        <div class="text-h6">{{canal.sidebar.components.name}}</div>
                        <q-list>
                            <q-item v-for="(component, i) in canal.sidebar.components.components" :key="`c-${i}`">
                                <q-item-section>
                                    <q-checkbox v-model="opcoes"
                                            :val="component.id" 
                                            :label="component.name"
                                            color="orange" />
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </div>
                    <div class="col-sm-3">
                        <div class="text-h6">{{canal.sidebar.niveis.name}}</div>
                        <q-list>
                            <q-item v-for="(component, i) in canal.sidebar.niveis.components" :key="`n-${i}`">
                                <q-item-section>
                                    <q-checkbox v-model="opcoes"
                                            :val="component.id" 
                                            :label="component.name"
                                            color="orange" />
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </div>
                    
                </q-card-section>
                <q-card-section class="row">
                {{tipos}}
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
import { QList, QItem, QItemSection, QCheckbox, QCardSection } from "quasar";

export default {
  name: "AdvancedSearchForm",
  props: ["dialog"],
  data() {
    return {
      dialog: false,
      maximizedToggle: true,
      tipos: [],
      licencas: [],
      opcoes: []
    };
  },
  computed: {
    ...mapState(["canal"])
  }
};
</script>
