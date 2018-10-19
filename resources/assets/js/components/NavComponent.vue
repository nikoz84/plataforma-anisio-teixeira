<template>
    <nav class="navbar navbar-default navbar-static-top">
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
    </nav>
</template>

<script>
    export default {
        name : 'nav-app',
        data () {
            return {

            }
        },
        mounted() {
        },
        methods: {
            logout(){
                localStorage.clear();
                this.$router.push('/');
            },
            get(endpoint){
            axios.get(`/api-v1/${endpoint}`).then(resp =>{
                this.$parent.paginator = resp.data.paginator;
                this.$parent.title = resp.data.title;
            }).catch(error =>{
                console.log(error.response)
            })
        }
        }
    }
</script>
<style lang="sass" scoped>

</style>