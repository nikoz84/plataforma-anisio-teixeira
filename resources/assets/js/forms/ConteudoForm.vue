<template>
  <div class="q-pa-md">
    <form v-on:submit.prevent="send($route.params.action)" >
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
          <label for="editor">Descrição</label>
          <q-editor v-model="description" min-height="15rem" id="editor"/>
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
        title="Tags"
        icon="settings"
        disable
      >
       <q-badge color="secondary" multi-line class="q-mb-md">
      Model: {{ tags || 'empty' }}
    </q-badge>
        <q-select
          filled
          :value="tags"
          use-input
          fill-input
          use-chips
          multiple
          stack-label
          map-options
          input-debounce="300"
          @input="inputValue"
          :options="autocompleteTags"
          @filter="getTags"
        />
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
          <q-btn color="primary" label="Enviar" />
          <q-btn flat @click="step = 3" color="primary" label="Voltar" class="q-ml-sm" />
        </q-stepper-navigation>
      </q-step>
       </q-stepper>
    </form>
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
  QStepperNavigation
} from "quasar";

export default {
  name: "ConteudoForm",
  delay: 2000,
  components: {
    QInput,
    QEditor,
    QCard,
    QSelect,
    QCardSection,
    QStepper,
    QStep,
    QStepperNavigation,
    ShowErrors
  },
  data() {
    return {
      autocompleteTags: [],
      categories: [],
      step: 1,
      license_id: "",
      canal_id: "",
      category_id: "",
      tipo_id: "",
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
      is_site: false
    };
  },
  mounted() {
    if (this.$route.params.action == "editar") {
      this.fetchConteudo(this.$route.params);
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
    send(action) {
      if (action == "editar") {
        this.updateConteudo(this.getConteudo());
      } else {
        this.createConteudo(this.getConteudo());
      }
    },
    inputValue(val, done) {
      console.log(val);
      //this.tags = this.tags.concat(val);

      done;
      //this.tags = Array.isArray(val) ? val[0] : [];
    },
    getTags(val, update, abort) {
      update(() => {
        if (val === "" && val.length < 3) {
          return;
        } else {
          //this.tags = this.tags.concat();
          axios.get(`tags/autocomplete/${val}`).then(resp => {
            this.autocompleteTags = resp.data.metadata;
          });
        }
      });
    },
    getConteudo() {
      return {
        license_id: this.license_id,
        canal_id: this.canal_id,
        category_id: this.category_id,
        tipo_id: this.tipo_id,
        site: this.site,
        title: this.title,
        description: this.description,
        authors: this.authors,
        source: this.source,
        image: this.image,
        tags: this.tags,
        niveis: this.niveis,
        components: this.components,
        terms: this.terms,
        is_approved: this.is_approved,
        is_featured: this.is_featured,
        is_site: this.is_site
      };
    }
  }
};
</script>
<style lang="scss" scoped>
/* Hide all steps by default: */
.tab {
  display: none;
}

/* Make circles that indicate the steps of the form: */
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none;
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}

/* Mark the active step: */
.step.active {
  opacity: 1;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #4caf50;
}
</style>
