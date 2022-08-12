<template>
  <div class="q-pa-md row justify-center q-gutter-xs">
    <q-card class="col-sm-6">
      <q-card-section class="q-gutter-sm">
        <q-input
          :loading="loadingState"
          clearable
          debounce="300"
          label="Pesquisar conteúdo por título"
          v-model="term"
        >
          <template v-slot:append>
            <q-btn color="primary" icon="search" @click="search()"></q-btn>
          </template>
        </q-input>
        <div class="q-pa-lg flex flex-center" v-if="paginator.total > 0">
          <q-pagination
            v-model="paginator.current_page"
            :max="paginator.last_page"
            boundary-numbers
            @input="getPage"
          />
        </div>
        <q-list bordered separator>
          <q-item
            @click="selectItem(conteudo)"
            clickable
            v-ripple
            v-for="conteudo in conteudos"
            :key="conteudo.id"
            :id="conteudo.id"
          >
            <q-item-section>
              <q-item-label caption>{{ conteudo.tipo.name }}</q-item-label>
              <q-item-label v-html="conteudo.title"></q-item-label>
            </q-item-section>
            <q-item-section side>
              <q-icon :name="`img:${conteudo.tipo.icon}`" color="green" />
            </q-item-section>
          </q-item>
        </q-list>
      </q-card-section>
    </q-card>
    <q-card class="col-sm-5">
      <q-card-section>
        <Player :arquivos="conteudo.arquivos" :tipo="conteudo.tipo"></Player>
      </q-card-section>
      <q-card-section v-if="conteudo && conteudo.title">
        <div>
          <div v-html="conteudo.title"></div>
          <q-separator></q-separator>
        </div>
        <div v-if="conteudo && conteudo.tipo">
          Tipo: {{ conteudo.tipo.name }}
        </div>
        <q-separator></q-separator>

        <div v-if="hasSite">
          <a target="__blank" :href="hasSite">{{ hasSite }}</a>
          <q-separator></q-separator>
        </div>
        <div v-if="conteudo.download">
          {{ conteudo.download }}
        </div>
        <!-- a download :href="conteudo.download"></a-->
      </q-card-section>
      <q-card-actions>
        <q-btn
          label="Editar"
          color="primary"
          :to="`/admin/conteudos/editar/${conteudo.id}`"
        ></q-btn>
      </q-card-actions>
    </q-card>
    <q-card class="col-sm-11">
      <q-card-section>
        <q-btn label="Criar Nova PlayList" @click="openModal"></q-btn>
      </q-card-section>
    </q-card>
  </div>
</template>

<script>
import { mapMutations, mapState } from "vuex";
import PlayListModalForm from "./PlayListModalForm.vue";
import { Player } from "@/components/player";
export default {
  name: "PlayListForm",
  components: { PlayListModalForm, Player },
  data() {
    return {
      term: "",
      conteudos: [],
      errors: [],
      paginator: {
        per_pege: 8,
        current_page: 1,
      },
      loadingState: false,
      render: false,
    };
  },
  computed: {
    ...mapState(["conteudo"]),
    hasSite() {
      return this.conteudo && this.conteudo.options
        ? this.conteudo.options.site
        : null;
    },
  },
  methods: {
    ...mapMutations(["SET_CONTEUDO"]),
    async search() {
      const params = {
        per_page: this.paginator.per_page,
        page: this.paginator.current_page,
      };
      this.loadingState = true;
      console.log(params);
      const { data } = await axios.get(`/playlist/search/${this.term}`, {
        params,
      });

      console.log(data);

      if (data.success) {
        this.loadingState = false;
        this.conteudos = data.paginator.data;
        this.paginator = data.paginator;

        console.log(this.paginator);
      } else {
        console.log("erro", data);
      }

      this.loadingState = false;
    },
    getPage(page) {
      this.paginator.current_page = page;
      this.search();
    },
    selectItem(conteudo) {
      console.log(conteudo);
      this.SET_CONTEUDO(conteudo);
    },

    openModal() {
      this.$q
        .dialog({
          component: PlayListModalForm,
          parent: this,
          text: "something",
          // ...more.props...
        })
        .onOk(() => {
          console.log("OK");
        })
        .onCancel(() => {
          console.log("Cancel");
        })
        .onDismiss(() => {
          console.log("Called on OK or Cancel");
        });
    },
  },
};
</script>

<style></style>
