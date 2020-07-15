<template>
  <div class="row q-gutter-xs">
    <q-card class="col-sm-5">
      <q-card-section class="q-gutter-sm">
        <!-- CANAL --> 
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
          @input="getCategories"
        />
        <!-- CATEGORIAS --> 
        <q-btn-dropdown
            class="full-width q-py-sm bg-light"
            stretch 
            dropdown-icon="arrow_drop_down" 
            flat 
            :label="categoryName"
            v-if="categories && categories.length > 0">
          <q-list dense>
            <q-item clickable dense 
                  v-for="(category, i) in categories" 
                  :key="i"
                  v-close-popup="category.sub_categories.length == 0"
                  @click="selectCategory(category)">
              <q-item-section>{{category.name}}</q-item-section>
              <q-item-section side v-if="category.sub_categories && category.sub_categories.length > 0">
                <q-icon name="keyboard_arrow_right" />
              </q-item-section>
              <!-- SUBCATEGORIAS --> 
              <q-menu anchor="center middle" self="center middle" v-if="category.sub_categories">
                <q-list>
                  <q-item v-for="(subcategory,n) in category.sub_categories" 
                          :key="n" 
                          clickable
                          dense
                          v-close-popup
                          @click="selectCategory(subcategory)">
                    <q-item-section>
                      {{subcategory.name}}
                    </q-item-section>
                  </q-item>
                </q-list>
              </q-menu>
            </q-item>
          </q-list>
        </q-btn-dropdown>
        <strong class="text-center">
          {{  selectedCategory ? `Escolha: ${selectedCategory}` : '' }}
        </strong>
        <!-- TIPO DE MIDIA --> 
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
        <!-- TITULO --> 
        <q-input outlined v-model="conteudo.title" label="Título do conteúdo" />
        <!-- AUTORES --> 
        <q-input outlined v-model="conteudo.authors" label="Autores" />
        <!-- FONTE --> 
        <q-input outlined v-model="conteudo.source" label="Fonte" />
        <!-- DESCRIÇÃO --> 
        <div class="q-mt-md">
          <p class="text-center">Escreva uma descrição do conteúdo</p>
        </div>
        <q-editor v-model="conteudo.description" min-height="15rem" />
      </q-card-section>
      <q-card-section>
        <!-- TAGS --> 
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
          <!-- IMAGEM DE DESTAQUE --> 
        <q-input
          @input="val => { file = val[0];}"
          outlined
          type="file"
          hint="Imagem de Destaque"
        />
        <!-- ARQUIVO DE UPLOAD --> 
        <q-input
          class="q-mt-md"
          @input="val => {file = val[0];}"
          outlined
          type="file"
          hint="Arquivo para Download"
        />
        <!-- ENVIAR SITE --> 
        <q-input
          outlined
          v-model="conteudo.options.site"
          label="URL do Site"
          hint="Exemplo: http://dominio.com.br"
        />
      </q-card-section>
      <q-card-section>
        <!-- CONTEUDO APROVADO --> 
        <div class="q-gutter-sm">
          <q-checkbox
            v-model="conteudo.is_approved"
            label="Aprovar conteúdo"
            color="pink"
          />
          <!-- MARCAR COMO DESTAQUE --> 
          <q-checkbox
            v-model="conteudo.is_featured"
            label="Marcar como destaque"
            color="pink"
          />
        </div>
      </q-card-section>
      <q-card-section>
        <!-- SALVAR --> 
        <q-btn
          class="full-width"
          color="primary"
          @click="save()"
          label="Salvar"
        ></q-btn>
      </q-card-section>
    </q-card>

    <q-card class="col-sm-3">
      <q-card-section>
        <!-- COMPONENTES CURRICULARES --> 
        <div v-if="componentes">
          <div
            v-for="(component, i) in componentes"
            :key="`c-${i}`"
            :index="component.id"
          >
            <div class="text-center text-negative q-pt-md">
              {{ component.name }}
            </div>
            <q-separator class="q-mt-lg" inset color="negative"></q-separator>
            <q-list>
              <q-item tag="label" 
                v-ripple v-for="(component, i) in component.componentes"
                :key="`child-com-${i}`">
                <q-item-section avatar>
                  <q-checkbox
                    v-model="componentesCurriculares"
                    :val="component.id"
                    color="negative"
                  />
                </q-item-section>
                <q-item-label class="q-pt-sm">
                  {{component.name}}
                </q-item-label>
              </q-item>
            </q-list>
            <q-separator class="q-mt-lg" inset color="negative"></q-separator>
          </div>
        </div>
        
      </q-card-section>
      
      
    </q-card>
    <q-card class="col-sm-3">
      <q-card-section>
        <!-- NIVEIS DE ENSINO --> 
        <div v-if="niveis">
          <div
            v-for="(nivel, n) in niveis"
            :key="`n-${n}`"
            :index="nivel.id"
          >
            <div class="text-center text-positive q-pt-md">
              {{ nivel.name }}
            </div>
            <q-separator class="q-mt-lg" inset color="positive"></q-separator>
            <q-list>
              <q-item tag="label" 
                v-ripple v-for="(component, i) in nivel.componentes"
                :key="`child-com-${i}`">
                <q-item-section avatar>
                  <q-checkbox
                    v-model="componentesCurriculares"
                    :val="component.id"
                    color="teal"
                  />
                </q-item-section>
                <q-item-label class="q-pt-sm">
                  {{component.name}}
                </q-item-label>
              </q-item>
            </q-list>
            <q-separator class="q-mt-lg" inset color="positive"></q-separator>
          </div>
        </div>
      </q-card-section>
    </q-card>
  </div>
</template>

<script>
import { mapGetters, mapActions, mapState, mapMutations } from "vuex";
import { ShowErrors } from "@forms/shared";
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
      canais: [],
      tipos: [],
      tipo_id: null,
      componentesCurriculares: [],
      licencas: [],
      autocompleteTags: [],
      categoryName: null,
      selectedCategory: '',
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
  computed: {
    ...mapState(["componentes", "niveis"])
  },
  methods: {
    save() {
      
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
      console.log(this.conteudo);
      form.append("title", this.conteudo.title);
      
      form.append("description", this.conteudo.description);
      form.append("source", this.conteudo.source);
      form.append("authors", this.conteudo.authors);
      form.append("options_site", this.conteudo.options.site);
      form.append("image", this.conteudo.image);
      form.append("tags", this.conteudo.tags);
      form.append("componentes", this.componentesCurriculares);
      form.append("terms", this.terms);
      form.append("is_approved", this.conteudo.is_approved);
      form.append("is_featured", this.conteudo.is_featured);
      form.append("is_site", this.conteudo.is_site);
      if (this.$route.params.action == "editar") {
        form.append("id", this.conteudo.id);
        form.append("_method", "PUT");
      }
    },
    async getCategories(val) {
      const id = val.id;
      const { data } = await axios.get(`/categorias/canal/${id}`);
      
      this.categories = data.metadata.categories;
      this.categoryName = data.metadata.category_name;
    },
    selectCategory(category) {
      if(category.parent_id === null && category.sub_categories.length > 0){
        return;
      } else if(category.parent_id != null && !category.sub_categories){
        this.conteudo.category_id = category.id;
        this.selectedCategory = category.name;
      } else {
        console.log(category)
        this.conteudo.category_id = category.id;
        this.selectedCategory = category.name;
      }
      
    },
    async getData() {
      const canais = axios.get("/canais?select");
      const tipos = axios.get("/tipos?select");
      const licencas = axios.get("/licencas?select");
      let responses = await axios.all([canais, tipos, licencas]);

      this.canais = responses[0].data.metadata;
      this.tipos = responses[1].data.metadata;
      this.licencas = responses[2].data.metadata;
      
      if (this.$route.params.id) {
        let { data } = await axios.get("/conteudos/" + this.$route.params.id);
        this.conteudo = data.metadata;
        this.componentesCurriculares = data.metadata.componentes.map(a => a.id);
      }

      if(this.conteudo.category){
        this.getCategories(this.conteudo.canal);
        const category = this.conteudo.category
        this.selectedCategory = category.name;
      }
    },
    addTag(val, done) {
      const form = new FormData();
      const http = axios;

      if (this.autocompleteTags.length == 0) {
        this.showTagModal(val);
      }
    },
    showTagModal(val){
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
                let { data } = await http.post("/tags", form);
                if (data.success) {
                  let id = data.metadata.id;
                  let label = data.metadata.name;
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
