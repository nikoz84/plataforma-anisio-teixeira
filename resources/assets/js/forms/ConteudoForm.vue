<template>
  <div class="row q-gutter-sm q-pa-md">
    <q-card class="col-sm-5">
      <q-card-section class="q-gutter-sm">
        <q-select
          outlined
          option-value="id"
          option-label="name"
          ransition-show="scale"
          transition-hide="scale"
          v-model="conteudo.canal"
          :options="canais"
          label="Escolha um Canal"
          behavior="dialog"
        />
        <q-select
          outlined
          stack-label
          option-value="id"
          option-label="name"
          transition-show="flip-up"
          transition-hide="flip-down"
          v-model="conteudo.tipo"
          :options="tipos"
          label="Tipo de Mídia"
          behavior="dialog"
        />
        <q-input outlined v-model="conteudo.title" label="Título do conteúdo" />
        <q-input outlined v-model="conteudo.authors" label="Autores" />
        <q-input outlined v-model="conteudo.source" label="Fonte" />
        <div class="q-mt-md">
          <p class="text-center">Escreva uma descrição do conteúdo</p>
        </div>
        <q-editor v-model="conteudo.description" min-height="15rem" />
        <q-card flat bordered>
          <q-card-section v-html="conteudo.description" />
        </q-card>
      </q-card-section>
    </q-card>

    <q-card class="col-sm-4">
      <q-card-section class="q-gutter-sm">
        <q-select
          outlined
          v-model="conteudo.tags"
          use-input
          multiple
          option-value="id"
          option-label="name"
          hint="Palavras chave"
          use-chips
          stack-label
          input-debounce="300"
          new-value-mode="add-unique"
          @new-value="addTag"
          :options="autocompleteTags"
          @filter="getTags"
        />
      </q-card-section>
      <q-card-section>
        <q-img 
          loading="lazy" 
          width="100%" 
          height="200" 
          :src="conteudo.image"
          placeholder-src="/img/fundo-padrao.svg"
          alt="imagem de destaque"/>
        <q-input
          @input="
            val => {
              file = val[0];
            }
          "
          outlined
          type="file"
          hint="Imagem de Destaque"
        />
        <q-input
          class="q-mt-md"
          @input="
            val => {
              file = val[0];
            }
          "
          outlined
          type="file"
          hint="Arquivo para Download"
        />
        <q-input
          outlined
          v-model="conteudo.options.site"
          label="URL do Site"
          hint="Exemplo: http://dominio.com.br"
        />
      </q-card-section>
    </q-card>
    <q-card class="col-sm-2">
      <q-card-section>
        <ul>
          <li v-for="(componente, i) in componentes" :key="i" v-text="componente.name"></li>
        </ul>
      </q-card-section>
      <q-card-actions class="absolute-bottom">
        <q-btn
          class="full-width"
          color="primary"
          @click="save()"
          label="Salvar"
        ></q-btn>
      </q-card-actions>
    </q-card>
  </div>
</template>

<script>
import { mapGetters, mapActions, mapState, mapMutations } from "vuex";
import ShowErrors from "../components/ShowErrors.vue";
import {
  QInput,
  QEditor,
  QCard,
  QCardSection,
  QSelect,
  QStepper,
  QStep,
  QStepperNavigation,
  QDialog,
  ClosePopup
} from "quasar";

export default {
  name: "ConteudoForm",
  directives: {
    ClosePopup
  },
  components: {
    QInput,
    QEditor,
    QCard,
    QSelect,
    QCardSection,
    QStepper,
    QStep,
    QStepperNavigation,
    ShowErrors,
    QDialog
  },
  data() {
    return {
      step: 1,
      conteudo: {
        license_id: null,
        canal_id: null,
        category_id: null,
        tipo_id: null,
        site: "",
        title: "",
        description: "",
        options: {
          site: null
        },
        authors: "",
        source: "",
        image: "",
        tags: [],
        componentes: [],
        terms: false,
        is_approved: false,
        is_featured: false,
        is_site: false
      },
      componentes: [],
      canais: [],
      tipos: [],
      licencas: [],
      autocompleteTags: [],
      categories: [],
      dialog: {
        text: "",
        open: false,
        confirm: false,
        new_tag: ""
      }
    };
  },
  mounted() {
    this.getData();
  },
  methods: {
    save() {
      console.log(this.conteudo);
      const form = new FormData();
      form.append(
        "license_id",
        this.conteudo.license ? this.conteudo.license.id : null
      );
      form.append("tipo_id", this.conteudo.tipo ? this.conteudo.tipo.id : null);
      form.append(
        "canal_id",
        this.conteudo.canal ? this.conteudo.canal.id : null
      );
      form.append(
        "category_id",
        this.conteudo.category ? this.conteudo.category.id : null
      );

      form.append("title", this.conteudo.title);
      form.append("description", this.conteudo.description);
      form.append("source", this.conteudo.source);
      form.append("authors", this.conteudo.authors);
      form.append("options_site", this.conteudo.options.site);
      form.append("image", this.conteudo.image);
      form.append("tags", this.conteudo.tags);
      form.append("componentes", this.conteudo.componentes);
      form.append("terms", this.terms);
      form.append("is_approved", this.conteudo.is_approved);
      form.append("is_featured", this.conteudo.is_featured);
      form.append("is_site", this.conteudo.is_site);
      if (this.$route.params.action == "editar") {
        form.append("id", this.conteudo.id);
        form.append("_method", "PUT");
      }
    },
    async getData() {
      const canais = axios.get("/canais?select");
      const tipos = axios.get("/tipos?select");
      const licencas = axios.get("/licencas?select");
      const componentes = axios.get("/componentes");
      let responses = await axios.all([canais, tipos, licencas, componentes]);

      this.canais = responses[0].data.metadata;
      this.tipos = responses[1].data.metadata;
      this.licencas = responses[2].data.metadata;
      this.componentes = responses[3].data.metadata;
      console.warn(responses);
      if (this.$route.params.id) {
        let conteudo = await axios.get("/conteudos/" + this.$route.params.id);
        this.conteudo = conteudo.data.metadata;
      }
    },
    addTag(val, done) {
      const form = new FormData();
      const http = axios;

      if (this.autocompleteTags.length == 0) {
        this.$q.notify({
          message: `Essa palavra chave não existe deseja adicionar ${val}?`,
          multiLine: true,
          color: "grey-4",
          textColor: "primary",
          possition: "center",
          timeout: Math.random() * 5000 + 5000,
          actions: [
            {
              label: "Confirmar",
              color: "positive",
              handler: async () => {
                form.append("name", val);
                let resp = await http.post("/tags", form);
                if (resp.data.success) {
                  let id = resp.data.metadata.id;
                  let label = resp.data.metadata.name;
                  done({ id, label });
                }
              }
            },
            {
              label: "Cancelar",
              color: "secondary",
              handler: () => {
                //this.tags = this.tags.pop(0,);
              }
            }
          ]
        });
      }
    },
    getTags(val, update, abort) {
      update(() => {
        if (val === "" && val.length < 3) {
          this.autocompleteTags = [];
        } else {
          const self = this;
          axios.get(`tags/autocomplete/${val}`).then(resp => {
            self.autocompleteTags = resp.data.metadata;
          });
        }
      });
    }
  }
};
</script>
<style lang="scss" scoped></style>
