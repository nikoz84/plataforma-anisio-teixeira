<template>
  <article class="q-pa-md">
    <div class="row no-wrap justify-center">
      <q-card class="col-sm-6">
        <h5 style="padding-left:15px" v-if="this.tipo.id != null">
          Edição de Tipo de Conteúdo <b>{{ this.tipoName }}</b>
        </h5>
        <h5 style="padding-left:15px" v-if="this.tipo.id == null">
          Cadastro de Tipo de Conteúdo
        </h5>
        <q-card-section>
          <q-input
            label="Nome"
            v-model="tipo.name"
            bottom-slots
            :error="errors.name && errors.name.length > 0"
          >
            <template v-slot:error>
              <ShowErrors :errors="errors.name"></ShowErrors>
            </template>
          </q-input>
          <q-select
            label="Extensões"
            v-model="tipo.options.formatos"
            use-chips
            multiple
            :options="optsFormatos"
          >
          </q-select>
        </q-card-section>
        <q-card-section>
          {{ tipo.icone }}
          <q-item-label style="margin-bottom:10px">
            <q-icon name="image" style="padding-bottom: 3px;" /><strong
              >Icone</strong
            >
          </q-item-label>

          <img width="50" height="50" :src="tipo.icon" />
        </q-card-section>
        <q-card-section>
          <q-btn
            @click.prevent="save()"
            class="full-width q-mt-md"
            label="Salvar"
            type="submit"
            color="primary"
          />
        </q-card-section>
      </q-card>
    </div>
  </article>
</template>
<script>
import { ShowErrors } from "@/forms/shared";

export default {
  name: "TipoForm",
  components: {
    ShowErrors,
  },
  data() {
    return {
      tipo: {
        name: "",
        icon: null,
        tipoName: "",
        options: {
          formatos: [],
        },
      },
      optsFormatos: [
        "ppt",
        "pps",
        "odp",
        "link",
        "pdf",
        "epub",
        "doc",
        "docx",
        "odt",
        "zip",
        "rar",
        "mp4",
        "mp3",
        "webm",
        "xls",
        "xml",
        "ods",
        "csv",
        "jpg",
        "jpeg",
        "png",
        "gif",
        "txt",
      ],
      errors: {},
    };
  },
  mounted() {
    this.getTipo();
  },
  methods: {
    async getTipo() {
      if (!this.$route.params.id) return;

      const { data } = await axios.get(`/tipos/${this.$route.params.id}`);
      this.tipo = data.metadata;
      this.tipoName = this.tipo.name;
    },
    async save() {
      const url = this.$route.params.id
        ? `/tipos/${this.$route.params.id}`
        : "/tipos";
      const method = this.$route.params.id ? "PUT" : "POST";

      const form = new FormData();
      form.append("name", this.tipo.name);
      form.append("options", JSON.stringify(this.tipo.options));
      if (this.$route.params.id) {
        form.append("_method", "PUT");
      }
      try {
        const { data } = await axios.post(url, form);
        if (data.success) {
          this.$router.push(`/admin/tipos/listar`);
        }
      } catch (ex) {
        this.errors = ex.errors;
      }
    },
  },
};
</script>
