<template>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Plataforma Anísio Teixeira</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mídias Educacionais <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <router-link tag="li" to="/">
                                <a>Inicio</a>
                            </router-link>
                            <router-link tag="li" to="/admin">
                                <a>Administração</a>
                            </router-link>
                            <router-link tag="li" :to="{ name: 'Inicio', params: {slug: 'tv-anisio-teixeira'}}">
                               <a v-on:click="get('canais')">Tv Anísio Teixeira</a>
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
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Usuário <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <router-link tag="li" to="/login" >
                                <a>Login</a>
                            </router-link>
                            <li>
                                <a v-on:click="logout()">Sair</a>
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

export default {
    name : 'nav-app',
    data () {
        return {

        }
    },
    mounted() {
    },
    methods: {
        async logout(){
            let http = new Http();
            let resp = await http.postData('/auth/logout');    
            if(resp.data.is_logout){
                console.log(resp.data.message)
                localStorage.clear();
                this.$router.push('/');
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