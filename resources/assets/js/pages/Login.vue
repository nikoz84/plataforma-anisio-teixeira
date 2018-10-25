<template>
  <section class="container-fluid heigth">
    <div class="row">
      <div class="col-md-6 col-md-offset-3 col-xs-10 col-xs-offset-1 center-xs">
        <h3 class="center-xs">Faça seu login agora</h3>
        <form v-on:submit.prevent="login()">
          <div class="form-group">
            <label for="email">E-mail</label>
            <input class="form-control" v-model="user.email" id="email" type="text">
          </div>
          <div class="form-group">
            <label for="senha">Senha</label>
            <input class="form-control" v-model="user.password" id="senha" type="password">
          </div>
          <button type="submit" class="btn btn-default">Login</button>
        </form>
        <div v-if="loginSuccess == false" class="alert alert-info" role="alert" >
          {{ message }}
        </div>
      </div>
    </div>  
  </section>
</template>

<script>
import Http from '../http.js';

export default {
  name: 'login',
  data () {
    return {
      user: {
        email: null,
        password: null
      },
      message : '',
      loginSuccess : null
    }
  },
  methods:{
    async login(){
      
      let data = { email: this.user.email, password: this.user.password };
      let http = new Http();
      let resp = await http.postData('/auth/login', data);
      
      localStorage.setItem('token', resp.data.access_token)
      
      if(localStorage.token == null || localStorage.token == undefined){
        this.$router.push('login')
      }

      this.$router.push('admin')
      
           
    }
  }
}
</script>