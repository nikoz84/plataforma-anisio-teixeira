<template>
      <div class="row">
            <h2><legend>ListaUsuários</legend></h2>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <td>Nome</td>
                        <td>E-mail institucional</td>
                        <td>Tipo de usuário</td>
                        <td>Ação</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for= "(user,i) in users" :key="i">
                        <td scope="row">{{ user.name}}</td>
                        <td>{{ user.email}}</td>
                        <td>{{ user.role}}</td>
                        <td><button type="button" class="btn btn-warning btn-xs">Editar</button> <button type="button" class="btn btn-danger btn-xs">Excluir</button></td>
                    </tr>
                </tbody>

            </table>
        </div>
</template>

<script>
import client from "../client.js";

export default {
  mounted() {
    console.log("sdf");
    this.getUsers();
  },

  data() {
    return {
      users: []
    };
  },

  methods: {
    async getUsers() {
      var urlUsers = "users";
      let resp = await axios.get(urlUsers);
      console.log(resp);
    }
  }
};
</script>