<template>
    <div class="row q-pa-md">
        <div class="col-sm-6 q-pa-md">
            <h5 v-if="role.id != null">Edição de Tipo de Usuário <b>{{this.roleName}}</b></h5>
            <h5 v-if="role.id == null">Cadastro de Tipo de Usuário</h5>
            <form v-on:submit.prevent="send()">
                <!-- NOME -->
                
                <q-card-section>
                    <q-input filled v-model="role.name" :error="errors.name && errors.name.length > 0"
                         label="Nome da função do usuário" />
                    <ShowErrors :errors="errors.name"></ShowErrors>
                </q-card-section>
                <q-card-section>
                    <q-btn @click.prevent="save()" class="full-width q-mt-md" label="Salvar" type="submit" color="primary"/>
                </q-card-section>
            </form>
        </div>
    </div>
</template>
<script>// @ts-nocheck

import { QInput } from 'quasar';
import { ShowErrors } from "@forms/shared";

export default {
  name: "RoleForm",
  components: { QInput, ShowErrors },
  data(){
      return {
          role:{
              name: ''
          },
          errors: {}
      }
  },
  mounted() {
    this.getRole()
  },
  methods:{
        async getRole(){
            if (!this.$route.params.id) return; 
            const { data } = await axios.get(`/roles/${this.$route.params.id}`);
            this.role = data.metadata;
            this.roleName = this.role.name;
        },
        async save()
        {
            const url = this.$route.params.id ? `/roles/${this.$route.params.id}` : '/roles';
            const method = this.$route.params.id ? 'PUT' : 'POST';
            const form = new FormData();
            form.append("_method", method);
            form.append('name', this.role.name);
            try {
            const {data} = await axios.post(url, form);
                if(data.success){
                    this.$router.push(`/admin/roles/listar`);
                }
            
            } catch(ex) {
                this.errors = ex.errors;
            }
        }
    }
};
</script>