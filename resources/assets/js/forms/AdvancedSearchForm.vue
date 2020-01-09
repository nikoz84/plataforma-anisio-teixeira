<template>
    <q-dialog
        ref="dialog" 
        @hide="onDialogHide"
        persistent
        :maximized="true"
        transition-show="slide-up"
        transition-hide="slide-down"
        >
        <q-card class="bg-grey-10 text-white">
            <q-bar>
                <div class="text-h6">Busca Avanzada</div>
                <q-space />
                <q-btn flat icon="close" v-close-popup aria-label="fechar">
                    <q-tooltip content-class="bg-white text-primary">Fechar</q-tooltip>
                </q-btn>
            </q-bar>
            <q-card-section class="row justify-center q-gutter-sm">
                <q-input class="input-search" filled dense dark color="teal"></q-input>
                <q-btn aria-label="pesquisar" class="btn-input" filled dark color="teal" icon="search" label="Pesquisar" @click="onOKClick"/>
                <q-select dense dark color="teal" v-model="perPage" stack-label :options="perPageOptions" hint="Itens Por Página" />
            </q-card-section>
            <q-card-section class="row justify-center q-gutter-sm">
                <div class="q-gutter-sm">
                  <q-radio dense dark color="teal" v-model="per" val="tag" label="Palavra chave" />
                  <q-radio dense dark color="teal" v-model="per" val="titulo" label="Título" />  
                </div>
                <div class="q-gutter-sm">
                  
                </div>
            </q-card-section>
            <q-card-section>
                {{tipos}} - {{licencas}} - {{componentes}} - {{per}} - {{perPage}}
            </q-card-section>
            <q-card-section style="max-height: 55vh" class="scroll">
              <div class="q-my-lg" v-if="canal.sidebar && canal.sidebar.tipos">
                  <div class="text-h6 text-orange q-pa-md">Tipos de Mídia</div>
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
                  <q-separator class="q-mt-lg" inset color="orange"></q-separator>
              </div>
              
              <div class="q-my-lg" v-if="canal.sidebar && canal.sidebar.licenses">
                  <div class="text-h6 text-positive q-pa-md">Licenças</div>
                  <div class="q-gutter-sm">
                      <q-checkbox dark
                                  v-for="(license, i) in canal.sidebar.licenses" 
                                  :key="`l-${i}`"
                                  v-model="licencas"
                                  :val="license.id" 
                                  :label="license.name" 
                                  color="positive" />
                  </div>
                  <q-separator class="q-mt-lg" inset color="positive"></q-separator>
              </div>
              <div v-if="canal.sidebar && canal.sidebar.components">
                  <div class="q-my-lg" v-for="(component, i) in canal.sidebar.components" :key="`c-${i}`" :index="component.id">
                      <div class="text-h6 text-negative q-pa-md">{{component.name}}</div>
                      <div class="q-gutter-sm" >
                          <q-checkbox  dark 
                                      v-for="(component, i) in component.components" 
                                      :key="`child-com-${i}`"
                                      v-model="componentes"
                                      :val="component.id" 
                                      :label="component.name"
                                      color="negative" />
                      </div>
                      <q-separator class="q-mt-lg" inset color="negative"></q-separator>
                  </div>
              </div>
              <div v-if="canal.sidebar && canal.sidebar.niveis">
                  <div class="q-my-lg" v-for="(nivel, n) in canal.sidebar.niveis" :key="`n-${n}`" :index="nivel.id">    
                      <div class="text-h6 text-teal q-pa-md">{{nivel.name}}</div>
                      <div class="q-gutter-sm">
                          <q-checkbox dark 
                                  v-for="(component, i) in nivel.components" 
                                  :key="`child-com-${i}`"
                                  v-model="componentes"
                                  :val="component.id" 
                                  :label="component.name"
                                  color="teal" />
                      </div>
                      <q-separator class="q-mt-lg" inset color="teal"></q-separator>
                  </div>
              </div>
            </q-card-section>
            <q-card-actions align="center" style="max-height: 5vh">
              <q-btn color="teal" label="Pesquisar" @click="onOKClick" />
              <q-btn color="secondary" label="Sair" @click="onCancelClick" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>
<script>
import { mapState } from "vuex";
import {
  QList,
  QItem,
  QItemSection,
  QCheckbox,
  QInput,
  QCard,
  QCardSection,
  QCardActions,
  QBtn,
  QSeparator,
  QRadio,
  QSelect
} from "quasar";

export default {
  name: "AdvancedSearchForm",
  components: {
    QList,
    QItem,
    QItemSection,
    QCheckbox,
    QInput,
    QCard,
    QCardSection,
    QCardActions,
    QBtn,
    QSeparator,
    QRadio,
    QSelect
  },
  data() {
    return {
      per: "tag",
      perPage: "15 itens",
      perPageOptions: [
        { label: "15 itens", value: 15 },
        { label: "30 itens", value: 30 },
        { label: "45 itens", value: 45 }
      ],
      maximizedToggle: true,
      tipos: [],
      licencas: [],
      componentes: []
    };
  },
  computed: {
    ...mapState(["canal"])
  },
  methods: {
    show() {
      this.$refs.dialog.show();
    },
    hide() {
      this.$refs.dialog.hide();
    },
    onDialogHide() {
      this.$emit("hide");
    },
    onOKClick() {
      this.$emit("ok");
      // or with payload: this.$emit('ok', { ... })

      this.hide();
    },
    onCancelClick() {
      this.$parent.$router.replace(`/recursos-educacionais/listar`);
      this.hide();
    }
  }
};
</script>
<style lang="stylus" scoped>
.input-search {
  width: 70%;
}

.btn-input {
  padding: 2px;
}
</style>
