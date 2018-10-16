<template>

  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3 col-xs-10 col-xs-offset-1 center-xs">
        <h3 class="center-xs">Faça seu login agora</h3>
        <form enctype="application/x-www-form-urlencoded" v-on:submit.prevent="login()">
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
      },
      token: '',
      message : '',
      loginSuccess : null
    }
  },
  methods:{
    login: function(){
      
      axios.post(`/api-v1/users/login`,
                 { email:this.user.email, 
                 password:this.user.password})
            .then(resp => {
              this.loginSuccess = resp.data.success;
              localStorage.setItem('token', resp.data.token)
              localStorage.setItem('login_success', this.loginSuccess)
              localStorage.setItem('username', resp.data.user.name)
              localStorage.setItem('user_id', resp.data.user.id)
              this.$router.push('Admin')
            }).catch(error => {
              if (error.response.status === 401) {
                this.message = error.response.data.message;
                this.loginSuccess = error.response.data.success;
                localStorage.setItem('login_success', this.loginSuccess)
              }
    
            })
    }
  }
}
</script>