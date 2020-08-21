<template>
  <article class="q-pa-md row items-start q-gutter-md">
    <q-card flat bordered>
      <q-card-section horizontal>
        <q-card-section class="q-pt-xs col-2">
          <div class="text-h5 q-mt-sm q-mb-xs" >
            {{ $route.params.action == 'adicionar' ? 'Adicionar Aplicativo' : 'Editar Aplicativo' }}
          </div>
        </q-card-section>
        <q-form v-on:submit.prevent="save()">
          <q-card-section class="row flex flex-start q-gutter-md">
          <!-- NOME -->
            <q-input class="col-sm-5" 
              v-model="aplicativo.name" 
              label="Nome do aplicativo" 
              :error="errors.name && errors.name.length > 0">
              <template v-slot:error>
                <ShowErrors :errors="errors.name"></ShowErrors>
              </template>
            </q-input>
            <!-- URL -->
            <q-input class="col-sm-5" v-model="aplicativo.url" label="URL do aplicativo" 
            :error="errors.url && errors.url.length > 0">
              <template v-slot:error>
                <ShowErrors :errors="errors.url"></ShowErrors>
              </template>
            </q-input>
           
          </q-card-section>
           <q-card-section class="row flex flex-start q-gutter-md">
             <div class="col-sm-5" style="text-align: center;" >
              <q-img class="center centered"
              loading="lazy" 
              style="height:150px; width:150px"
              :src="aplicativo.image"
              placeholder-src="/img/fundo-padrao.svg"
              alt=" Icone da categoria :"/>
            </div>
           </q-card-section>
           
          <q-card-section class="row flex flex-start q-gutter-md">
            <!-- IMAGEM DESTAQUE -->
           
            <q-input class="col-sm-5" @input="val => { image = val[0] }"
              type="file"
              hint="Imagem de destaque"
              bottom-slots
              @change="onFileChange"
              :error="errors && errors.image && errors.image.length > 0"
                >
              <template v-slot:error>
                <ShowErrors :errors="errors.image"></ShowErrors>
              </template>
            </q-input>
            
            <!-- CATEGORIA -->
            <q-select outlined 
              class="col-sm-5"
              v-model="aplicativo.category" 
              :options="categoriesList"
              option-value="id"
              option-label="name"
              use-input
              label="Escolha uma Categoria" 
              bottom-slots
              :error="errors.category_id && errors.category_id.length > 0">
              <template v-slot:error>
                <ShowErrors :errors="errors.category_id"></ShowErrors>
              </template>
            </q-select>
          </q-card-section>
          <q-card-section class="row flex flex-start q-gutter-md">
              <!-- TAGS -->
              <q-select class="col-sm-10"
                    filled
                    v-model="aplicativo.tags"
                    use-input
                    multiple
                    option-value="id"
                    option-label="name"
                    use-chips
                    hint="Adicione palavras chaves"
                    input-debounce="300"
                    new-value-mode="add-unique"
                    :options="tagsList"
                    @filter="getTags"
                    bottom-slots
                    :error="errors.tags && errors.tags.length > 0">
                <template v-slot:error>
                  <ShowErrors :errors="errors.tags"></ShowErrors>
                </template>
              </q-select>
              <!-- DESTAQUE -->
              <q-toggle
                    class="col-sm-10"
                    label="Marcar como destaque"
                    color="pink"
                    checked-icon="check"
                    unchecked-icon="clear"
                    v-model="aplicativo.options.is_featured"
                    bottom-slots
                    :error="errors.options_is_featured && errors.options_is_featured.length > 0"
                  >
                <template v-slot:error>
                  <ShowErrors :errors="errors.options_is_featured"></ShowErrors>
                </template>
              </q-toggle>

                <!-- DESCRIÇÃO -->
                <q-editor v-model="aplicativo.description" 
                  class="col-sm-10"
                  min-height="15rem"
                  ref="editor_ref"
                  @paste.native="evt => pasteCapture(evt)"
                  :toolbar="[['bold', 'italic', 'strike', 'underline']]"
                  >
                </q-editor>
                <div class="col-sm-10" v-if="errors.description && errors.description.length > 0">
                  <ShowErrors :errors="errors.description"></ShowErrors>
                </div>
                
          </q-card-section>
          <q-card-section class="row flex flex-start q-gutter-md">
            <q-btn class="col-sm-10 q-mt-xl" label="Salvar" type="submit" color="primary"/>
          </q-card-section>
        </q-form>
      </q-card-section>
    </q-card>
  </article>
</template>

<script>
import { QForm, QInput, QEditor, QSelect, QCard, QCardSection } from "quasar";
import { ShowErrors } from "@forms/shared";
import { prototype } from "stream";
import { PasteCapture } from "@mixins/RemoveFormat";

export default {
  name: "AplicativoForm",
  mixins: [PasteCapture],
  components: {
    QForm,
    QInput,
    QEditor,
    QSelect,
    QCard,
    QCardSection,
    ShowErrors
  },

  data() {
    return {
      aplicativo: {
        name: "",
        description: "",
        url: "",
        canal:null,
        tags: [],
        options: {
          is_featured: false,
          qt_access: 0

        },
        image: null,
        category_id: null
      },
      
      categoriesList: [],
      tagsList: [],
      canais:[],
      imagemAssociada: null,
      count: 0,
      errors: {}
    };
  },
  created() {
    this.getCategories();
    this.getAplicativo();
  },
  methods: {
    onFileChange(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            this.imagemAssociada = files[0];
        },
    save() {
      let form = new FormData();
      if(this.aplicativo.canal)
            form.append("canal_id", this.aplicativo.canal.id);
      if (this.$route.params.action === "editar") {
        form.append("id", this.$route.params.id);
        form.append("_method", "PUT");
      }
      form.append("name", this.aplicativo.name);
      form.append("description", this.aplicativo.description);
      if (this.aplicativo.category) {
        form.append("category_id", this.aplicativo.category.id);
      }
      
      form.append("url", this.aplicativo.url);
      form.append("options", JSON.stringify(this.aplicativo.options));
      if (this.imagemAssociada) {
        form.append("imagemAssociada", this.imagemAssociada);
      }
      if (this.aplicativo.tags.length) {
        let tags = this.aplicativo.tags.map(item => item.id);
        for (var i = 0; i < tags.length; i++) {
          form.append("tags[]", tags[i]);
        }
      }
      
      this.sendData(form);
    },
    async sendData(form) {
      let url = this.$route.params.id
        ? `/aplicativos/${this.$route.params.id}`
        : "/aplicativos";
      try {
        let resp = await axios.post(url, form);
        if (resp.data.success) {
          this.$router.push("/admin/aplicativos/listar");
        }
      } catch (ex) {
        this.errors = ex.errors;
      }
    },
    async getCategories() {
      let resp = await axios.get("/aplicativos/categories");
      if (resp.data.success) {
        this.categoriesList = resp.data.metadata;
      }
    },
    countCaracters(e) {
      if (e.target.value.length > 140) {
        this.success = true;
      }
      this.count = e.target.value.length;
    },
    async getAplicativo() {
      if (!this.$route.params.id) return;

      let resp = await axios.get(`/aplicativos/${this.$route.params.id}`);
      if (resp.data.success) {
        this.aplicativo = resp.data.metadata;
      }
    },
    getTags(val, update, abort) {
      update(() => {
        if (val === "" && val.length < 2) {
          this.tags = [];
        } else {
          const self = this;
          axios.get(`tags/autocomplete/${val}`).then(resp => {
            self.tagsList = resp.data.metadata;
          });
        }
      });
    },
    
  }
};
</script>
