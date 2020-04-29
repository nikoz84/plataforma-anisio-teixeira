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
        <strong>Busca Avançada</strong>
        <q-space />
        <q-btn flat icon="close" v-close-popup aria-label="fechar">
          <q-tooltip content-class="bg-white text-primary">Fechar</q-tooltip>
        </q-btn>
      </q-bar>
      <q-card-section class="col-sm-4">
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
        <q-btn
          aria-label="pesquisar"
          color="teal"
          label="Pesquisar"
          icon="search"
          @click="onSearch"
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
         <q-list padding bordered class="rounded-borders">
          <q-expansion-item
            dense
            dense-toggle
            expand-separator
            label="Tipos de Mídia"
            v-if="tipos"
          >
            <q-card>
              <q-card-section>
                <q-checkbox
                  v-for="(tipo, i) in tipos"
                  :key="`t-${i}`"
                  v-model="tiposModel"
                  :val="tipo.id"
                  :label="tipo.name"
                  color="orange"
                />
              </q-card-section>
            </q-card>
          </q-expansion-item>
          <q-expansion-item
            dense
            dense-toggle
            expand-separator
            label="Licenças"
            v-if="licencas"
          >
            <q-card>
              <q-card-section>
                <q-checkbox
                  v-for="(license, i) in licencas"
                  :key="`l-${i}`"
                  v-model="licencasModel"
                  :val="license.id"
                  :label="license.name"
                  color="positive"
                />
              </q-card-section>
            </q-card>
          </q-expansion-item>
          <!-- Componentes Curriculares -->
          <q-expansion-item
            dense
            dense-toggle
            expand-separator
            v-for="(component, i) in componentes"
            :key="`c-${i}`"
            :index="component.id"
            :label="component.name"
          >
            <q-card>
              <q-card-section>
                <q-checkbox
                  v-for="(component, i) in component.componentes"
                  :key="`child-com-${i}`"
                  v-model="componentesModel"
                  :val="component.id"
                  :label="component.name"
                  color="negative"
                />
              </q-card-section>
            </q-card>
          </q-expansion-item>

          <q-expansion-item
            dense
            dense-toggle
            expand-separator
            v-for="(nivel, n) in niveis"
            :key="`n-${n}`"
            :index="nivel.id"
            :label="nivel.name"
          >
            <q-card>
              <q-card-section>
                <q-checkbox
                  v-for="(component, i) in nivel.componentes"
                  :key="`child-com-${i}`"
                  v-model="componentesModel"
                  :val="component.id"
                  :label="component.name"
                  color="teal"
                />
              </q-card-section>
            </q-card>
          </q-expansion-item>
        </q-list>
    </q-card-section>
    </q-card>
    <q-card class="my-card" flat bordered>
      <q-item>
        <q-item-section avatar>
          <q-avatar>
            <img src="https://cdn.quasar.dev/img/boy-avatar.png">
          </q-avatar>
        </q-item-section>

        <q-item-section>
          <q-item-label>Title</q-item-label>
          <q-item-label caption>
            Subhead
          </q-item-label>
        </q-item-section>
      </q-item>

      <q-separator />

      <q-card-section horizontal>
        <q-card-section>
          asdasdadsd asdasd asda  asdasasd asd sad asds asdas dasdas ds 
        </q-card-section>

        <q-separator vertical />

        <q-card-section class="col-4">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit.
        </q-card-section>
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
