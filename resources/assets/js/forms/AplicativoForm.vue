<template>
  <article class="q-pa-md">
    <q-card class="row justify-start q-gutter-sm">
      <q-card-section>
        <div class="text-center text-h5" >
          {{ $route.params.action == 'adicionar' ? 'Adicionar Aplicativo' : 'Editar Aplicativo' }}
        </div>
      </q-card-section>
      <q-card-section>
        <form v-on:submit.prevent="save()">
          <!-- NOME -->
          <q-input v-model="aplicativo.name" label="Nome do aplicativo" 
          :error="errors.name && errors.name.length > 0">
            <template v-slot:error>
              <ShowErrors :errors="errors.name"></ShowErrors>
            </template>
          </q-input>
          <!-- IMAGEM DESTAQUE -->
          <q-input @input="val => { image = val[0] }"
            filled
            type="file"
            hint="Imagem de destaque"
            bottom-slots
            :error="errors && errors.image && errors.image.length > 0"
              >
            <template v-slot:error>
              <ShowErrors :errors="errors.image"></ShowErrors>
            </template>
          </q-input>
          <!-- URL -->
          <q-input v-model="aplicativo.url" label="URL do aplicativo" 
          :error="errors.url && errors.url.length > 0">
            <template v-slot:error>
              <ShowErrors :errors="errors.url"></ShowErrors>
            </template>
          </q-input>
          <!-- CATEGORIA -->
          <q-select outlined 
            v-model="aplicativo.category" 
            :options="categories"
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
          <!-- DESTAQUE -->
          <q-toggle
                class="q-mt-md"
                label="Marcar como destaque"
                color="pink"
                checked-icon="check"
                unchecked-icon="clear"
                v-model="aplicativo.options.is_featured"
                bottom-slots
                :error="errors.is_featured && errors.is_featured.length > 0"
              >
            <template v-slot:error>
              <ShowErrors :errors="errors.is_featured"></ShowErrors>
            </template>
          </q-toggle>
          <!-- DESCRIÇÃO -->
          <q-editor v-model="aplicativo.description" 
            min-height="15rem"
            bottom-slots
            :error="errors.description && errors.description.length > 0">
            <template v-slot:error>
              <ShowErrors :errors="errors.description"></ShowErrors>
            </template>
          </q-editor>
          <q-btn class="full-width q-mt-md" label="Salvar" type="submit" color="primary"/>
        </form>
      </q-card-section>
    </q-card>
  </article>
</template>

<script>
import { QForm, QInput, QEditor, QSelect, QCard, QCardSection } from "quasar";
import ShowErrors from "../components/ShowErrors.vue";

export default {
  name: "AplicativoForm",
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
        tags: [],
        options: {
          is_featured: false
        },
        image: null,
        category: null,
        image: null,
        tags: []
      },
      categories: [],
      image: null,
      count: 0,
      errors: {}
    };
  },
  created() {
    this.getCategories();
    this.getAplicativo();
  },
  methods: {
    async save() {
      let id = this.$route.params.id ? `/${this.$route.params.id}` : "";

      let form = new FormData();

      form.append("name", this.aplicativo.name);
      form.append("description", this.aplicativo.description);
      form.append("category_id", this.aplicativo.category.id);
      form.append("url", this.aplicativo.url);
      form.append("tags", this.aplicativo.tags);
      form.append("is_featured", this.aplicativo.options.is_featured);

      if (this.image) {
        form.append("image", this.image, this.image.name);
      }

      form.append("aplicativo", JSON.stringify(this.aplicativo));
      if (this.$route.params.action == "editar") {
        form.append("id", this.$route.params.id);
        form.append("_method", "PUT");
      }

      try {
        let resp = await axios.post(`/aplicativos` + id, form);
        console.log(resp);
      } catch (response) {
        console.log(response);
        this.errors = response.errors;
      }
    },
    async getCategories() {
      let resp = await axios.get("/aplicativos/categories");
      if (resp.data.success) {
        this.categories = resp.data.metadata;
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
        console.log(resp.data.metadata);
        this.aplicativo = resp.data.metadata;
      }
    }
  }
};
</script>
