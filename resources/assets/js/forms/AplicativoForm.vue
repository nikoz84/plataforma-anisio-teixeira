<template>
  <div class="row">
    <form v-on:submit.prevent="send()">
      aplicativos
    </form>
  </div>
</template>

<script>
import showErrors from "../components/ShowErrors.vue";

export default {
  name: "AplicativoForm",
  components: {
    erros: showErrors
  },
  data() {
    return {
      name: "",
      description: null,
      url: null,
      is_featured: false,
      tags: null,
      options: {},
      image: null,
      category_id: "",
      categories: [],
      message: null,
      count: 0,
      success: false,
      isError: true,
      isUpdate: false,
      textButton: "Criar",
      errors: {
        name: [],
        url: [],
        description: [],
        category: [],
        image: []
      }
    };
  },
  created() {
    //this.getCategories();
    if (this.$route.params.update) {
      this.getAplicativo();
      this.isUpdate = true;
      this.textButton = "Editar";
    }
  },
  methods: {
    send() {
      if (this.isUpdate) {
        this.editAplicativo();
      } else {
        this.createAplicativo();
      }
    },
    async createAplicativo() {
      this.options = {
        qt_access: 0
      };
      if (!this.image) return;
      let form = new FormData();
      form.append("name", this.name);
      form.append("description", this.description);
      form.append("category_id", this.category_id);
      form.append("canal_id", localStorage.canal_id);
      form.append("tags", this.tags);
      form.append("url", this.url);
      form.append("is_featured", this.is_featured);
      form.append("options", JSON.stringify(this.options));
      form.append("image", this.image, this.image.name);

      let resp = await axios.post(`/aplicativos`, form);

      if (resp.data.success) {
        this.$router.push({
          name: "Listar",
          params: { slug: this.$route.params.slug }
        });
      } else {
        this.isError = resp.data.success;
        this.message = resp.data.message;
        if (resp.data.errors) {
          this.errors = resp.data.errors;
        }

        setTimeout(() => {
          this.isError = true;
        }, 3000);
      }
    },
    async getCategories() {
      let resp = await axios.get(`/categories/aplicativos`);

      this.categories = resp.data.categories;
    },
    onFileChange(e) {
      this.image = e.target.files[0];
    },
    countCaracters(e) {
      if (e.target.value.length > 140) {
        this.success = true;
      }
      this.count = e.target.value.length;
    },
    async getAplicativo() {
      let resp = await axios.get(`/aplicativos/${this.$route.params.id}`);
      if (resp.data.success) {
        this.name = resp.data.aplicativo.name;
        this.category_id = resp.data.aplicativo.category_id;
        this.description = resp.data.aplicativo.description;
        this.url = resp.data.aplicativo.url;
        this.is_featured = resp.data.aplicativo.is_featured;
        this.image = resp.data.aplicativo.image;
      }
    },
    async editAplicativo() {
      let params = {
        name: this.name,
        category_id: this.category_id,
        canal_id: localStorage.canal_id,
        description: this.description,
        url: this.url,
        is_featured: this.is_featured,
        token: localStorage.token
      };

      let resp = await axios.put(
        `/aplicativos/${this.$route.params.id}`,
        params
      );
      if (resp.data.success) {
        this.$router.push(
          `/aplicativos-educacionais/exibir/${this.$route.params.id}`
        );
      }
    }
  }
};
</script>
