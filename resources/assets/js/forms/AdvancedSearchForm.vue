<template>
  <q-dialog
    ref="dialog"
    @hide="onDialogHide"
    persistent
    :maximized="true"
    transition-show="slide-up"
    transition-hide="slide-down"
  >
    <q-card class="">
      <q-bar>
        <div>Busca Avançada</div>
        <q-space />
        <q-btn
          aria-label="pesquisar"
          color="teal"
          label="Pesquisar"
          icon="search"
          @click="onSearch"
        />
        <q-space />
        <q-btn flat icon="close" v-close-popup aria-label="fechar">
          <q-tooltip content-class="bg-white text-primary">Fechar</q-tooltip>
        </q-btn>
      </q-bar>
      <q-card-section class="row justify-center q-gutter-sm">
        <q-input
          v-model="term"
          class="input-search"
          filled
          dense
          hint="Pesquisar"
        ></q-input>
        <q-select
          dense
          v-model="limit"
          stack-label
          :options="perPageOptions"
          hint="Itens por Página"
        />
      </q-card-section>
      <q-card-section class="row justify-center q-gutter-sm">
        <div class="q-gutter-sm">
          <q-radio
            dense
            color="teal"
            v-model="per"
            val="tag"
            label="Palavra chave"
          />
          <q-radio
            dense
            color="teal"
            v-model="per"
            val="titulo"
            label="Título"
          />
        </div>
        <div class="q-gutter-sm"></div>
      </q-card-section>
      <!--q-card-section>
        {{ tiposModel }} - {{ licencasModel }} - {{ componentesModel }} -
        {{ per }} - {{ limit }}
      </q-card-section -->
      <q-card-section>
        <div class="q-my-lg" v-if="tipos">
          <div class="text-h6 text-orange q-pa-md">Tipos de Mídia</div>
          <div class="q-gutter-sm">
            <q-checkbox
              v-for="(tipo, i) in tipos"
              :key="`t-${i}`"
              v-model="tiposModel"
              :val="tipo.id"
              :label="tipo.name"
              color="orange"
            />
          </div>
          <q-separator class="q-mt-lg" inset color="orange"></q-separator>
        </div>

        <div class="q-my-lg" v-if="licencas">
          <div class="text-h6 text-positive q-pa-md">Licenças</div>
          <div class="q-gutter-sm">
            <q-checkbox
              v-for="(license, i) in licencas"
              :key="`l-${i}`"
              v-model="licencasModel"
              :val="license.id"
              :label="license.name"
              color="positive"
            />
          </div>
          <q-separator class="q-mt-lg" inset color="positive"></q-separator>
        </div>
        <div v-if="componentes">
          <div
            class="q-my-lg"
            v-for="(component, i) in componentes"
            :key="`c-${i}`"
            :index="component.id"
          >
            <div class="text-h6 text-negative q-pa-md">
              {{ component.name }}
            </div>
            <div class="q-gutter-sm">
              <q-checkbox
                v-for="(component, i) in component.componentes"
                :key="`child-com-${i}`"
                v-model="componentesModel"
                :val="component.id"
                :label="component.name"
                color="negative"
              />
            </div>
            <q-separator class="q-mt-lg" inset color="negative"></q-separator>
          </div>
        </div>
        <div v-if="niveis">
          <div
            class="q-my-lg"
            v-for="(nivel, n) in niveis"
            :key="`n-${n}`"
            :index="nivel.id"
          >
            <div class="text-h6 text-teal q-pa-md">{{ nivel.name }}</div>
            <div class="q-gutter-sm">
              <q-checkbox
                v-for="(component, i) in nivel.componentes"
                :key="`child-com-${i}`"
                v-model="componentesModel"
                :val="component.id"
                :label="component.name"
                color="teal"
              />
            </div>
            <q-separator class="q-mt-lg" inset color="teal"></q-separator>
          </div>
        </div>
      </q-card-section>
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
      term: "",
      per: "tag",
      limit: { label: "15 itens", value: 15 },
      perPageOptions: [
        { label: "15 itens", value: 15 },
        { label: "30 itens", value: 30 },
        { label: "45 itens", value: 45 }
      ],
      maximizedToggle: true,
      tiposModel: [],
      licencasModel: [],
      componentesModel: [],
      niveisModel: []
    };
  },
  computed: {
    ...mapState(["tipos", "licencas", "componentes", "niveis"])
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
    onSearch() {
      this.$emit("ok");

      let params = {
        tipos: this.tiposModel,
        componentes: this.componentesModel,
        licencas: this.licencasModel
      };
      let search = new URLSearchParams(location.search);
      search.set("tipos", this.tiposModel);
      search.set("licencas", this.licencasModel);
      search.set("componentes", this.componentesModel);
      search.set("per", this.per);
      search.set("busca", this.term);
      search.set("limit", this.limit.value);

      this.$parent.$router.replace(
        `/recursos-educacionais/listar?${search.toString()}`
      );

      this.hide();
    },
    processData(append, data) {
      for (var i = 0; i < tags.length; i++) {
        form.append("tags[]", tags[i]);
      }
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
  width: 50%;
}

.btn-input {
  padding: 2px;
}
</style>
