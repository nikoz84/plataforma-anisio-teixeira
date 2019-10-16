<template>
    <div class="row q-pa-md">
        <div class="col-sm-12">
            <form v-on:submit.prevent="save()">
                <q-input filled v-model.trim="user.name" label="Usuário" hint="Nome Completo" style="margin-bottom:15px;"></q-input>
                <q-input filled v-model.trim="user.email" label="E-mail" hint="Correio eletrónico" style="margin-bottom:15px;"></q-input>
                <q-input filled v-model.trim="user.options.neighborhood" label="Bairro" hint="Bairro" style="margin-bottom:15px;"></q-input>
                <q-select filled 
                        option-value="id"
                        option-label="label" 
                        use-chips
                        v-model="user.role" 
                        :options="roles" 
                        label="Tipo de Usuário" 
                        style="margin-bottom:15px;"/>
                <q-select filled 
                        option-value="id"
                        option-label="label" 
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
import { QInput, QRadio, QDate, QBtn, date } from "quasar";

export default {
  name: "UserForm",
  components: { QInput, QRadio, QDate, QBtn, date },
  data() {
    return {
      user: {
        name: "",
        email: "",
        canais: [],
        created_at: null,
        role: {
          id: null,
          label: ""
        },
        options: {
          sexo: null,
          birthday: null,
          neighborhood: null,
          telefone: null,
          is_active: false
        }
      },
      roles: [],
      canais: []
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
    async save() {
      let id = this.$route.params.id ? `/${this.$route.params.id}` : "";
      let form = new FormData();
      form.append("name", this.user.name);
      form.append("email", this.user.email);
      form.append("role_id", this.user.role.id);
      form.append("options", JSON.stringify(this.options));
      if (this.$route.params.action == "editar") {
        form.append("_method", "PUT");
      }
      console.log(this.user);
      //let resp = await axios.post(this.$route.params.slug + id, form);
      //console.log(resp);
    },
    async getUser() {
      if (!this.$route.params.id) return;
      let url = `${this.$route.params.slug}/${this.$route.params.id}`;
      let resp = await axios.get(url);
      if (resp.data.success) {
        console.log(resp.data.metadata);
        this.user = resp.data.metadata;
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