<template>
    <div class="conteiner">
        <div class="row col-lg-6 col-xs-offset-3">
            <h2><legend>Lista Usuários</legend></h2>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <td>Nome</td>
                        <td>E-mail</td>
                        <td>Tipo de usuário</td>
                        <td>Ação</td>
                    </tr>
                </thead>
                <tbody>
                     <tr v-for= "user in users" v-bind:key="user.id">
                        <td scope="row">{{ user.name }}</td>
                        <td scope="row">{{ user.email }}</td>
                        <td scope="row">{{ user.options.role }}</td>
                        <td>
                        <button type="button"
                                  class="btn btn-info btn-xs" title="Alterar senha"
                                  v-on:click="resetpassword(user.id)">
                                  <i class="glyphicon glyphicon-lock"></i>
                          </button>
                          <button type="button"
                                  class="btn btn-warning btn-xs"
                                  v-on:click="updateUsuario(user.id)">
                                  Editar
                          </button>
                          <button type="button"
                                  class="btn btn-danger btn-xs"
                                  v-on:click="deleteUsuario(user.id)">
                                  Apagar
                          </button>
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>
</template>

<script>
import client from '../client.js'

export default {
  name: "ListarUser",
  data() {
    return {
      users: []
    };
  },
  mounted() {
    this.getUsers();
  },
  methods: {
    async getUsers() {
      let urlUsers = `/users`;
      let resp = await client.get(urlUsers);
      console.warn(resp);
      this.users = resp.data.users;
    },
    async deleteUsuario(id) {
      
      let resp = await client.delete(`/users/${id}`);
      console.warn(resp)
      if(resp.data.success){
        this.$router.go({ path: 'listar' });
      }
    },

    updateUsuario(id) {
      this.$router.push({ name: 'EditarUsuario', params: {id: id, update:true}});
      //console.warn(this.$route.params)
    },

    resetpassword(id) {
      this.$router.push({ name: 'UserEdit', params: {id: id, update:true}});
      //console.warn(this.$route.params)
    }
  }
};
</script>