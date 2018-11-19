<template>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu-deslizante" aria-expanded="false">
                <span class="sr-only">Menu deslizante</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">
                    <img class="logo pull-left" alt="Logo da plataforma" src="/logo.svg" width="30" height="30">
                    <span class="name pull-left hidden-xs">Plataforma Anísio Teixeira</span> 
                </a>
            </div>
            <div class="collapse navbar-collapse" id="menu-deslizante">
                <ul class="nav navbar-nav navbar-right">

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mídias Educacionais <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <router-link tag="li" to="/admin">
                                <a>Administração</a>
                            </router-link>
                            <router-link tag="li" :to="{ name: 'Inicio', params: {slug: 'recursos-educacionais-abertos'}}">
                               <a>Recursos Educacionais Abertos</a>
                            </router-link>
                            <router-link tag="li" :to="{ name: 'Inicio', params: {slug: 'tv-anisio-teixeira'}}">
                               <a>Tv Anísio Teixeira</a>
                            </router-link>
                            <router-link tag="li" :to="{ name: 'Inicio', params: {slug: 'radio-anisio-teixeira'}}">
                                <a>Radio Anísio Teixeira</a>
                            </router-link>
                            <router-link tag="li" :to="{ name: 'Inicio', params: {slug: 'emitec'}}">
                                <a>Emitec</a>
                            </router-link>
                            <router-link tag="li" :to="{ name: 'Inicio', params: {slug: 'projetos-artisticos'}}">
                                <a>Projetos Artisticos</a>
                            </router-link>
                            <router-link tag="li" :to="{ name: 'Inicio', params: {slug: 'sites-tematicos'}}">
                                <a>Sites Temáticos</a>
                            </router-link>
                            <router-link tag="li" :to="{ name: 'Inicio', params: {slug: 'aplicativos-educacionais'}}">
                                <a>Aplicativos Educacionais</a>
                            </router-link>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            Usuário 
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <router-link tag="li" to="/usuario/login" v-if="!isLogged">
                                <a>Login</a>
                            </router-link>
                            <li v-if="isLogged">
                                <a v-on:click.prevent="logout()">Sair</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="progress-container">
            <div class="progress-bar" id="bar"></div>
        </div>
    </nav>
</template>

<script>
import Http from '../http.js';
import store from '../store.js'

export default {
    name : 'nav-app',
    data () {
        return {
            isLogged : store.state.isLogged   
        }
    },
    mounted() {
               
    },
    methods: {
        async logout(){
            let http = new Http();
            let params = {token: localStorage.token };             
            
            let resp = await http.postData('/auth/logout', params);
            
            if(resp.data.success){
                localStorage.clear();
                this.$router.push('/usuario/login');
                store.commit('LOGOUT_USER');
                
            }else{
                localStorage.clear();
            }
                
            
            
        },
        handleScroll (event) {
            let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            var scrolled = (winScroll / height) * 100;
            document.getElementById("bar").style.width = scrolled + "%";
        }    
    
    },
    created () {
        window.addEventListener('scroll', this.handleScroll);
    },
    destroyed () {
        window.removeEventListener('scroll', this.handleScroll);
    }
}
</script>
<style lang="scss" scoped>
.logo{
    width: 30px;
    height: 30px;
}
.name{
    font-size: 20px;
    color: #333;
    padding-top: 5px;
    display: block;
}
.progress-container {
  width: 100%;
  height: 2px;
  background: #ccc;
}
.progress-bar {
  height: 2px;
  background: #1e78c2;
  width: 0%;
}
</style>