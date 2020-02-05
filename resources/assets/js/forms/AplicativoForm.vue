<template>
  <article class="q-pa-md">
    <q-card class="row justify-start q-gutter-sm">
      <q-card-section>
        <div class="text-center text-h5" >
          {{ $route.params.action == 'adicionar' ? 'Adicionar Aplicativo' : 'Editar Aplicativo' }}
        </div>
      </q-card-section>
      <q-card-section>
        <q-form @submit.prevent="save()" ref="denunciaForm">
          <q-input label="Nome do aplicativo" bottom-slots>
            <template v-slot:error>
                <ShowErrors :errors="errors.message"></ShowErrors>
              </template>
          </q-input>
          <q-input label="descrição"></q-input>
        </q-form>
      </q-card-section>
    </q-card>
  </article>
</template>

<script>
import { QCard } from "quasar";
import showErrors from "../components/ShowErrors.vue";

export default {
  name: "AplicativoForm",
  components: {
    QCard,
    showErrors
  },
  data() {
    return {
      aplicativo: {},
      name: "",
      description: null,
      url: null,
      tags: null,
      options: {},
      image: null,
      category_id: null,
      categories: [],
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
      this.options = {
        qt_access: 0
      };
      if (!this.image) return;
      let form = new FormData();
      form.append("name", this.aplicativo.name);
      form.append("description", this.aplicativo.description);
      form.append("category_id", this.aplicativo.category_id);
      form.append("canal_id", 9);
      form.append("tags", this.aplicativo.tags);
      form.append("url", this.aplicativo.url);
      form.append("is_featured", this.aplicativo.is_featured);
      form.append("options", JSON.stringify(this.aplicativo.options));
      form.append("image", this.image, this.image.name);
      if (this.$route.params.action == "editar") {
        form.append("id", this.$route.params.id);
        form.append("_method", "PUT");
      }

      try {
        let resp = await axios.post(`/aplicativos`, form);
        this.$router.push("/admin/aplicativos/listar");
      } catch (response) {
        this.errors = response.errors;
      }
    },
    async getCategories() {
      let resp = await axios.get("/aplicativos/categories");

      this.categories = resp.data.categories;
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
      console.log(resp);
    }
  }
};
</script>
