<template>
    <div class="row q-pa-md">
        <div class="col-sm-12">
            <h5 v-if="user.id != null">Edição de dados do Usuário(a) <b>{{this.userName}}</b></h5>
            <h5 v-if="user.id == null">Cadastro de Novo Usuário(a)</h5>
            <form @submit.prevent="save()">
              <div class="col-4">
                <q-img :src="user.image" 
                       width="150px"
                       height="150px"
                       loading="lazy"
                       style="width:150px;height:150px;" 
                       placeholder-src="/img/fundo-padrao.svg" 
                       :ratio="1">
                </q-img>
                <q-input
                        class="q-mt-md"
                        @input="val => {file = val[0];}"
                        outlined
                        accept=".png, .webp, .svg, .jpeg, .jpg"
                        type="file"
                        @change="onFileChange" hint="Imagem de perfil"></q-input>
              </div>
                <ShowErrors :errors="errors.name"></ShowErrors>
                <q-input filled v-model.trim="user.name" :error="errors.name && errors.name.length > 0" 
                         label="Usuário" hint="Nome Completo" style="margin-bottom:15px;"></q-input>
                <q-input filled v-model.trim="user.email" label="E-mail" hint="Correio eletrónico" style="margin-bottom:15px;"></q-input>
                <q-input filled v-model.trim="user.options.neighborhood" label="Bairro" hint="Bairro" style="margin-bottom:15px;"></q-input>
                <q-select filled 
                        option-value="id"
                        option-label="name" 
                        use-chips
                        v-model="user.role" 
                        emmit-value
                        :options="roles" 
                        label="Tipo de Usuário" 
                        style="margin-bottom:15px;"/>
                <q-select filled 
                        option-value="id"
                        option-label="name" 
                        use-chips
                        multiple
                        v-model="user.canais" 
                        :options="canais" 
                        label="Pertence ao Canal" 
                        style="margin-bottom:15px;"
                        hint="Este usuário poderá criar e editar conteúdos nos seguintes canais"/>
                <div style="margin-bottom:15px;">
                    Sexo:
                    <q-radio v-model="user.options.sexo" val="f" label="Femenino" />
                    <q-radio v-model="user.options.sexo" val="m" label="Masculino" />
                </div>
                <q-input
                    style="margin-bottom:15px;"
                    filled
                    v-model="user.options.telefone"
                    label="Telefone"
                    mask="(##) # #### - ####"
                    fill-mask
                    hint="DDD: (##) # #### - ####"
                />
                <q-date v-model="user.options.birthday"
                        v-model.trim="user.options.birthday" :error="errors.birthday && errors.birthday.length > 0" 
                        mask="YYYY-MM-DD" 
                        landscape
                        style="margin-bottom:15px;"/>
                
                <q-input v-if="user.id" filled v-model="user.created_at" label="Possui conta desde" disable readonly style="margin-bottom:15px;"/>

                
                <q-btn class="full-width" label="Salvar" type="submit" color="primary"></q-btn>
            </form>
        </div>
    </div>
</template>

<script>


import { QInput, QRadio, QDate, QBtn, date, QUploader } from "quasar";
import { FileUpload, ShowErrors } from "@forms/shared";

export default {
  name: "UserForm",
  components: { QInput, QRadio, QDate, QBtn, date, QUploader, FileUpload, ShowErrors },
  data() {
    return {
      user: {
        name: "",
        email: "",
        arquivoImagem:null,
        canais: [],
        created_at: null,
        image: "",
        role:null,
        role_id: null,
        options: {
          sexo: null,
          birthday: null,
          neighborhood: null,
          telefone: null,
          is_active: false
        }
      },
      file: null,
      roles: [],
      canais: [],
      errors:{}
    };
  },

  created() {
    this.getUser();
    this.getRoles();
    this.getCanais();
  },
  computed: {
    birthday() {
      return date.formatDate(this.user.options.birthday, "DD/MM/YYYY");
    }
  },
  methods: {
    onFileChange(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            console.log("file:", files);
            this.user.arquivoImagem = files[0];
        },
    async save() {
      let id = this.$route.params.id ? `/${this.$route.params.id}` : "";
      let form = new FormData();
      form.append("name", this.user.name);
      form.append("email", this.user.email);
      form.append("role_id", this.user.role.id);
      form.append("options", JSON.stringify(this.user.options));
      if(this.user.arquivoImagem)
      form.append("arquivoImagem", this.user.arquivoImagem);
      if (this.$route.params.action == "editar") {
        form.append("_method", "PUT");
      }
      if (this.file) {
        form.append("file", this.file, this.file.name);
      }
      try
      {
        let resp = await axios.post(this.$route.params.slug + id, form);
        this.$router.push(`/admin/usuarios/listar`);
      }
      catch(ex)
      {
        this.errors = ex.errors;
      }
    },
    async getUser() {
      if (!this.$route.params.id) return;
      let url = `${this.$route.params.slug}/${this.$route.params.id}`;
      let resp = await axios.get(url);
      if (resp.data.success) {
        this.user = resp.data.metadata;
        this.userName = this.user.name;
      }
    },
    async getRoles() {
      let resp = await axios.get(`/roles?select`);
      if (resp.data.success) {
        this.roles = resp.data.metadata;
      }
    },
    async getCanais() {
      let resp = await axios.get(`/canais?select`);
      if (resp.data.success) {
        this.canais = resp.data.metadata;
      }
    }
  }
};
</script>