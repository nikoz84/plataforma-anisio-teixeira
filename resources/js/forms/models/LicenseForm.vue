<template>
  <div class="row q-gutter-xs">
    <form class="col-sm-12" v-on:submit.prevent="save()">
      <div class="row">
        <q-card class="col-sm-12">
          <q-card-section class="q-gutter-sm">
            <q-input
              bottom-slots
              :error="errors.name && errors.name.length > 0"
              filled
              v-model.trim="licenca.name"
              label="Nome:*"
              hint="Nome da Categoria por extenso"
            ></q-input>
            <!-- LICENCA -->
            <q-select
              outlined
              option-value="id"
              option-label="name"
              ransition-show="scale"
              transition-hide="scale"
              v-model="licenca.parent"
              :options="licencas"
              label="Licença relacionada"
              hint="Licença ao qual está licença pertence"
              behavior="dialog"
            />
            <!-- DESCRIÇÃO -->
            <q-item-label> </q-item-label>
            <textarea
              v-model="licenca.description"
              label="Descrição de licença"
              :error="errors.description && errors.description.length > 0"
              style="width:100%"
            >
            </textarea>
            <!-- SITE -->
            <q-input
              bottom-slots
              :error="errors.site && errors.site.length > 0"
              filled
              v-model.trim="licenca.site"
              label="Site referenciado: :*"
              hint="Url do site responsável pelas definições da licensa em questão"
            ></q-input>
            <!-- ICONE -->
            <q-item-label style="margin-bottom:10px">
              <q-icon name="image" style="padding-bottom: 3px;" /><strong
                >Icone da licença</strong
              >
            </q-item-label>
            <q-img
              loading="lazy"
              style="height:150px; width:150px"
              :src="licenca.image"
              placeholder-src="@/assets/img/fundo-padrao.svg"
              alt=" Icone da licença :"
            />
            <q-input
              @input="
                (val) => {
                  file = val[0];
                }
              "
              outlined
              bottom-slots
              :error="
                errors.imagemAssociada && errors.imagemAssociada.length > 0
              "
              @change="onFileChange"
              accept=".png, .webp, .svg, .jpeg, .jpg"
              type="file"
              hint="Imagem de Destaque"
            />

            <q-btn
              class="full-width"
              color="primary"
              @click="save()"
              label="Salvar"
            ></q-btn>
          </q-card-section>
        </q-card>
      </div>
    </form>
  </div>
</template>
<script>
import { RecaptchaForm, ShowErrors } from "@/forms/shared";
export default {
  name: "LicencaForm",
  computed: {
    url() {
      return `http://${window.location.hostname}/${slug}`;
    },
  },
  mounted() {
    this.getData();
  },
  data() {
    return {
      licenca: {
        image: null,
        name: "",
        description: "",
        imagemAssociada: null,
        parent_id: null,
        parent: null,
      },
      licencas: [],
      errors: {},
    };
  },
  methods: {
    async save() {
      const form = new FormData();
      form.append("name", this.licenca.name);
      form.append("description", this.licenca.description);
      form.append("site", this.licenca.site);
      if (this.licenca.parent) form.append("parent_id", this.licenca.parent.id);
      if (this.licenca.imagemAssociada) {
        form.append("imagemAssociada", this.licenca.imagemAssociada);
      }
      try {
        if (this.$route.params.action == "editar") {
          form.append("id", this.licenca.id);
          form.append("_method", "PUT");
          let resp = await axios.post(
            this.$route.params.slug + "/" + this.licenca.id,
            form
          );
        } else {
          let resp = await axios.post(this.$route.params.slug, form);
        }
        this.$router.push(`/admin/licencas/listar`);
      } catch (ex) {
        console.log(ex);
        this.errors = ex.errors;
      }
    },
    onFileChange(e) {
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.licenca.imagemAssociada = files[0];
    },
    async getData() {
      const licencas = await axios.get("/licencas?select");
      console.log(licencas.data.metadata);
      this.licencas = licencas.data.metadata;
      if (this.$route.params.id) {
        let licenca = await axios.get("/licencas/" + this.$route.params.id);
        this.licenca = licenca.data.metadata;
        console.log(this.licenca);
      }
    },
  },
};
</script>
