<template>
    <div class="row">
      <div class="col-md-6 col-md-offset-4 col-xs-10 col-xs-offset-1 center-xs">
        <div class="panel panel-default col-md-7">
            <div class="panel-heading">
                Editar Perfil
            </div>
            <div class="panel-body">
                <form>
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input class="form-control" v-model="user.nome" id="nome" type="text">
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input class="form-control" v-model="user.email" id="email" type="text">
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input class="form-control" v-model="user.password" id="senha" type="password">
                    </div>
                    <button type="submit" class="btn btn-default" v-on:click.prevent="alterar()">Alterar</button>
                    
                    <!--<router-link to="/usuario/recuperar-senha">
                        Recuperar senha
                    </router-link>
                    <router-link to="/usuario/registro">
                        Cadastrese
                    </router-link>-->
                </form>

                <transition  name="custom-classes-transition"
                            enter-active-class="animated shake"
                            leave-active-class="animated fadeOut">
                <div v-if="!isError" class="alert alert-info" role="alert" >
                    {{ message }}
                </div>
                </transition>
            </div>
        </div>
      </div>
    </div>
</template>
<script>
import client from '../client.js';
import store from '../store/index.js';

export default {
  name: 'LoginForm',
  data () {
    return {
      user: {
        name: null,
        email: null,
        password: null
      },
      message : '',
      isError : true
    }
  },
  created(){
    console.log(this.$route)
    if(this.$route.update){
      console.log(this.$route.update, this.$route.id)
    }
  },
  beforeCreate () {
    if (!store.state.isLogged) {
        this.$router.push('/usuario/editar')
    }
  },
  methods:{
    async alterar(){
      let data = { name: this.user.name, email: this.user.email, password: this.user.password };
      let resp = await axios.post('usuario/', data);
      
      if(!resp.data.success){
        this.isError = resp.data.success;
        this.message = resp.data.message;
        this.$router.push('/usuario/editar')
        setTimeout(()=>{
          this.isError = true;
        },3000)
      }else{
        this.isError = resp.data.success;
        if(resp.data.token.access_token){
          localStorage.setItem('token', resp.data.token.access_token)
          store.commit('LOGIN_USER');
          this.$router.push('/admin');
        }
      }
    }
  }
}
</script>
<style lang="scss" scoped>
form { margin-top: 30px; margin-bottom: 30px;}
</style>