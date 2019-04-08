<template>
    <div class="conteiner">
        <div class="row col-lg-6 col-xs-offset-3">
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
                    <tr v-for= "user in users">
                        <td scope="row">{{ user.name}}</td>
                        <td>{{ user.email}}</td>
                        <td>{{ user.role}}</td>
                        <td><button type="button" class="btn btn-warning btn-xs">Editar</button> <button type="button" class="btn btn-danger btn-xs">Excluir</button></td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>
</template>

<script>
import Http from "../http.js";
const http = new Http();

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