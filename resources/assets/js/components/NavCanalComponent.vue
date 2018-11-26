<template>
    <nav>
        <ul class="nav nav-pills">
            <router-link tag="li" :to="{ name: 'Inicio', params: {slug: $route.params.slug}}">
                <a>Home</a>
            </router-link> 
            <router-link tag="li" :to="{ name: 'Listar', params: {slug: $route.params.slug}}">
                <a>Listar</a>
            </router-link> 
            <router-link tag="li" :to="{ name: 'AdicionarConteudo', params: {slug: $route.params.slug}}" v-if="showAdicionarConteudo">
                <a>Adicionar</a>
            </router-link>
            <router-link tag="li" :to="{ name: 'AdicionarAplicativo', params: {slug: $route.params.slug}}" v-if="showAdicionarAplicativo">
                <a>Adicionar</a>
            </router-link>
        </ul>    
    </nav>
</template>
<script>
import store from '../store/index.js'

export default {
    name : 'NavCanal',
    data(){
        return {
            isLogged: store.state.isLogged
        }
    },
    beforeCreate() {
        console.log(store.state.isLogged)
    },
    computed:{
        showAdicionarConteudo (){
            if(this.isLogged && this.$route.params.slug != 'aplicativos-educacionais'){
                return this.isLogged;
            } 
            return false;
        },
        showAdicionarAplicativo (){
            if(this.isLogged && this.$route.params.slug == 'aplicativos-educacionais'){
                return this.isLogged;
            } 
            return false;
        }
    }

    
}
</script>
<style lang="scss" scoped>

</style>
