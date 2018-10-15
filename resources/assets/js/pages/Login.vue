<template>
<div class="login">
  <md-toolbar class="center-xs">
    <div class="md-title">Plataforma Anisio Teixeira</div>
  </md-toolbar>
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3 col-xs-10 col-xs-offset-1 center-xs">
        <md-subheader class="center-xs">Faça seu login agora</md-subheader>
        <form v-on:submit="handleSubmit($event)">
          <md-input-container>
            <label>E-mail</label>
            <md-input v-model="user.email"></md-input>
          </md-input-container>
          <md-input-container md-has-password>
            <label>Senha</label>
            <md-input type="password" v-model="user.password"></md-input>
          </md-input-container>
          <md-button type="submit" class="md-raised md-primary"><md-icon class=""></md-icon> Login</md-button>
        </form>
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
      }
    }
  }
}
</script>