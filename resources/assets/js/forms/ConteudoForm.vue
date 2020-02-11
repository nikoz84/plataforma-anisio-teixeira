<template>
<div class="row">
  <div class="col-md-8">
    <form v-on:submit.prevent="save()" >
        <q-stepper
          v-model="step"
          vertical
          color="primary"
          animated
        >
          <q-step
            :name="1"
            title="Canal e Tipo de Mídia"
            icon="settings"
            :done="step > 1"
          >
            <q-select outlined v-model="canal_id" :options="canais" label="Escolha um Canal" />
            <q-select outlined v-model="tipo_id" :options="tiposForm" label="Tipo de Mídia" />
            <q-stepper-navigation>
              <q-btn @click="step = 2" color="primary" label="Próximo" />
            </q-stepper-navigation>
          </q-step>
          <q-step
            :name="2"
            title="Título, Autores, Fonte e Descrição"
            icon="settings"
            :done="step > 2"
          >
            <q-input outlined v-model="title" label="Título do conteúdo" />
            <q-input outlined v-model="authors" label="Autores" />
            <q-input outlined v-model="source" label="Fonte" />
            <div class="q-mt-md">
              <p class="text-center">Escreva uma descrição do conteúdo</p>
            </div>
            <q-editor v-model="description" min-height="15rem"/>
            <q-card flat bordered>
              <q-card-section v-html="description" />
            </q-card>
            <q-stepper-navigation>
              <q-btn @click="step = 3" color="primary" label="Próximo" />
              <q-btn flat @click="step = 1" color="primary" label="Voltar" class="q-ml-sm" />
            </q-stepper-navigation>
          </q-step>
          <q-step
            :name="3"
            title="Palavras Chave"
            icon="settings"
            :done="step > 3"
          >
            <q-select
                filled
                v-model="tags"
                use-input
                multiple
                option-value="id"
                option-label="name"
                use-chips
                stack-label
                input-debounce="300"
                new-value-mode="add-unique"
                @new-value="addTag"
                :options="autocompleteTags"
                @filter="getTags"
              />
          <q-stepper-navigation>
            <q-btn @click="step = 4" color="primary" label="Próximo" />
            <q-btn flat @click="step = 2" color="primary" label="Voltar" class="q-ml-sm" />
          </q-stepper-navigation>
        </q-step>

        <q-step
            :name="4"
            title="Componentes curriculares"
            icon="settings"
          >
            Try out different ad text to see what brings in the most customers, and learn how to
            enhance your ads using features like ad extensions. If you run into any problems with
            your ads, find out how to tell if they're running and how to resolve approval issues.

            <q-stepper-navigation>
              <q-btn label="Salvar" type="submit" color="primary"/>
              <q-btn flat @click="step = 4" color="primary" label="Voltar" class="q-ml-sm" />
            </q-stepper-navigation>
          </q-step>
        </q-stepper>
        
      </form>
    </div>
    <div class="col-md-4">
      <q-card class="q-ml-sm">
        <q-input
          @input="val => { file = val[0] }"
          filled
          type="file"
          hint="Imagem de Destaque"
        />
        <q-input
          class="q-mt-md"
          @input="val => { file = val[0] }"
          filled
          type="file"
          hint="Arquivo para Download"
        />
        <q-input
          filled
          v-model="site"
          label="URL do Site"
          hint="Exemplo: http://dominio.com.br"
        />
      </q-card>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions, mapState, mapMutations } from "vuex";
import { mapFields } from "vuex-map-fields";
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
      autocompleteTags: [],
      categories: [],
      step: 1,
      license_id: null,
      canal_id: null,
      category_id: null,
      tipo_id: null,
      site: "",
      title: "",
      description: "",
      authors: "",
      source: "",
      image: "",
      tags: [],
      niveis: [],
      components: [],
      terms: false,
      is_approved: false,
      is_featured: false,
      is_site: false,
      dialog: {
        text: "",
        open: false,
        confirm: false,
        new_tag: ""
      }
    };
  },
  mounted() {
    if (this.$route.params.action == "editar") {
    }
    this.fetchTiposForSelect();
    //this.fetchLicenses();
    this.fetchCanaisForSelect();
  },
  computed: {
    ...mapState([
      "errors",
      "tiposForm",
      "conteudo",
      "licenses",
      "childsLicenses",
      "canais"
    ]),
    ...mapFields([])
  },
  methods: {
    ...mapActions([
      "fetchConteudo",
      "fetchTiposForSelect",
      "fetchLicenses",
      "fetchCanaisForSelect",
      "createConteudo",
      "updateConteudo"
    ]),
    save() {
      console.log(this.$route.params.action);
      /*
      if (this.$route.params.action == "editar") {
        this.updateConteudo(this.getConteudo());
      } else {
        this.createConteudo(this.getConteudo());
      }
      */
    },
    getConteudo() {
      if (!this.$route.params.id) return;
      const form = new FormData();
      form.append("title", this.title);
      form.append("description", this.description);
      form.append("source", this.source);
      form.append("authors", this.authors);
      form.append("license_id", this.license_id);
      form.append("canal_id", this.canal_id);
      form.append("category_id", this.category_id);
      form.append("tipo_id", this.tipo_id);
      form.append("site", this.site);
      form.append("image", this.image);
      form.append("tags", this.tags);
      form.append("niveis", this.niveis);
      form.append("components", this.components);
      form.append("terms", this.terms);
      form.append("is_approved", this.is_approved);
      form.append("is_featured", this.is_featured);
      form.append("is_site", this.is_site);
      if (this.$route.params.action == "editar") {
        form.append("_method", "PUT");
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
<style lang="scss" scoped>
</style>
