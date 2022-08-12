<template>
  <div class="q-pa-md">
    <q-card>
      <q-card-section>
        <h5 v-if="user.id != null">
          Edição de dados do Usuário(a) <b>{{ this.userName }}</b>
        </h5>
        <h5 v-if="user.id == null">Cadastro de Novo Usuário(a)</h5>

        <form @submit.prevent="save()">
          <div>
            <q-img
              :src="user.options.image"
              width="250"
              height="250"
              style="height: 300px"
              :placeholder-src="`/img/fundo-padrao.svg`"
            >
            </q-img>

            <q-input
              class="q-mt-md"
              @input="
                (val) => {
                  file = val[0];
                }
              "
              outlined
              accept=".png, .webp, .svg, .jpeg, .jpg"
              type="file"
              @change="onFileChange"
              hint="Imagem de perfil"
            >
            </q-input>
            <div v-if="errors && errors.arquivoImagem">
              <ShowErrors :errors="errors.arquivoImagem"></ShowErrors>
            </div>
          </div>
          <div class="col-4">
            <q-input
              filled
              v-model.trim="user.name"
              :error="errors.name && errors.name.length > 0"
              label="Usuário"
              hint="Nome Completo"
              style="margin-bottom:15px;"
            ></q-input>
            <q-input
              filled
              v-model.trim="user.email"
              label="E-mail"
              hint="Correio eletrónico"
              style="margin-bottom:15px;"
            ></q-input>

            <q-input
              v-model="user.password"
              filled
              :type="isPwd ? 'password' : 'text'"
              hint="Senha"
              bottom-slots
              :error="errors.password && errors.password.length > 0"
              autocomplete="off"
            >
              <template v-slot:append>
                <q-icon
                  :name="isPwd ? 'visibility_off' : 'visibility'"
                  class="cursor-pointer"
                  @click="isPwd = !isPwd"
                />
              </template>
              <template v-slot:error>
                <ShowErrors :errors="errors.password"></ShowErrors>
              </template>
            </q-input>
          </div>
          <q-input
            filled
            v-model.trim="user.options.neighborhood"
            label="Bairro"
            hint="Bairro"
            style="margin-bottom:15px;"
          ></q-input>
          <q-select
            filled
            option-value="id"
            option-label="name"
            use-chips
            v-model="user.role"
            :options="roles"
            label="Tipo de Usuário"
            style="margin-bottom:15px;"
          />

          <q-select
            filled
            option-value="id"
            option-label="name"
            use-chips
            multiple
            v-model="user.canais"
            :options="canais"
            label="Pertence ao Canal"
            style="margin-bottom:15px;"
            hint="Este usuário poderá criar e editar conteúdos nos seguintes canais"
          />
          <div style="margin-bottom:15px;">
            Gênero:
            <q-radio v-model="user.options.sexo" val="f" label="Femenino" />
            <q-radio v-model="user.options.sexo" val="m" label="Masculino" />
            <!--q-radio v-model="user.options.sexo" val="o" label="Outro" / -->
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
          <q-date
            v-model="user.options.birthday"
            v-model.trim="user.options.birthday"
            :error="errors.birthday && errors.birthday.length > 0"
            mask="YYYY-MM-DD"
            landscape
            style="margin-bottom:15px;"
          />

          <q-input
            v-if="user.id"
            filled
            v-model="user.created_at"
            label="Possui conta desde"
            disable
            readonly
            style="margin-bottom:15px;"
          />
          <div>
            Activo:
            <q-checkbox v-model="user.options.is_active" color="negative" />
          </div>
          <q-btn
            class="full-width"
            label="Salvar"
            type="submit"
            color="primary"
          ></q-btn>
        </form>
      </q-card-section>
    </q-card>
  </div>
</template>

<script>
import { date } from "quasar";
import { FileUpload, ShowErrors } from "@/forms/shared";

export default {
  name: "UserForm",
  components: {
    date,
    FileUpload,
    ShowErrors,
  },
  data() {
    return {
      isPwd: true,
      user: {
        name: "",
        email: "",
        arquivoImagem: null,
        canais: [],
        created_at: null,
        image: "",
        role: null,
        role_id: null,
        options: {
          sexo: null,
          birthday: null,
          neighborhood: null,
          telefone: null,
          is_active: 0,
        },
      },
      file: null,
      roles: [],
      canais: [],
      errors: {},
    };
  },

  created() {
    this.getUser();
    this.getRoles();
    this.getCanais();
  },
  computed: {
    birthday() {
      return date.formatDate(this.user.options.birthday, "YYYY/MM/DD");
    },
  },
  methods: {
    onFileChange(e) {
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      console.log("file:", files);
      this.user.arquivoImagem = files[0];
    },
    async save() {
      let url = this.$route.params.id
        ? `/usuarios/${this.$route.params.id}`
        : "/usuarios";
      let form = new FormData();

      form.append(
        "user",
        JSON.stringify({
          name: this.user.name,
          email: this.user.email,
          password: this.user.password,
          role_id: this.user.role.id,
          options: this.user.options,
        })
      );

      if (this.user.arquivoImagem)
        form.append("arquivoImagem", this.user.arquivoImagem);
      if (this.$route.params.id) {
        form.append("_method", "PUT");
      }
      if (this.file) {
        form.append("file", this.file, this.file.name);
      }
      try {
        const { data } = await axios.post(url, form);

        if (data.success) {
          this.$router.push(`/admin/usuarios/listar`);
        }
      } catch (ex) {
        this.errors = ex.errors;
      }
    },
    async getUser() {
      if (!this.$route.params.id) return;
      let url = `/usuarios/${this.$route.params.id}`;
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
    },
  },
};
</script>
