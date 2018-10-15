<template>

  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3 col-xs-10 col-xs-offset-1 center-xs">
        <h3 class="center-xs">Faça seu login agora</h3>
        <form enctype="application/x-www-form-urlencoded" v-on:submit.prevent="login()">
          <label for="email">E-mail</label>
          <input class="form-control" v-model="user.email" id="email" type="text">
          <label for="senha">Senha</label>
          <input class="form-control" v-model="user.password" id="senha" type="password">
          <button type="submit" class="btn btn-default">Login</button>
        </form>
      </div>
    </div>
  </div>

</template>

<script>

export default {
  name: 'login',
  data () {
    return {
      user: {
        email: null,
        password: null
      }
    }
  },
  methods:{
    login: function(){
      // console.log(this.user.email, this.user.password);
      axios.post(`/api-v1/users/login`,{ email:this.user.email, password:this.user.password}).then(function(resp){
        console.log(resp.data);
      })
    }
  }
}
</script>