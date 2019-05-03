<template>
    <nav>
        <ul class="nav nav-pills">
            <router-link tag="li" :to="{ name: 'Inicio', params: {slug: $route.params.slug}}" exact>
                <a>Home</a>
            </router-link>
            <router-link tag="li" :to="{ name: 'Listar', params: {slug: $route.params.slug}}">
                <a>Listar</a>
            </router-link>
            <router-link tag="li" :to="goTo">
                <a>Adicionar</a>
            </router-link> 
            <router-link tag="li" :to="setUrlDenuncia">
                <a>Denúnciar</a>
            </router-link> 
            <router-link tag="li" :to="getUrlFaleConosco">
                <a>Fale Conosco</a>
            </router-link> 
        </ul>
    </nav>
</template>
<script>
import store from '../store/index.js'

export default {
    name : 'NavCanal',
    props: ['hasAbout'],
    data(){
        return {
            isLogged: store.state.isLogged
        }
    },
    beforeCreate() {

    },
    computed:{
        showAdicionarAplicativo (){
            if(this.isLogged && this.$route.params.slug == 'aplicativos-educacionais'){
                return true;
            }
            return false;
        },
        goTo(){
            if(this.$route.params.slug == 'aplicativos-educacionais'){
                return { name:'AdicionarAplicativo', params: {slug: this.$route.params.slug}}; 
            }else{
                return { name:'AdicionarConteudo', params: {slug: this.$route.params.slug}};
            }
        },
        setUrlDenuncia(){
            localStorage.setItem('urlDenuncia',location.href);
            return { name:'DenunciaForm', params: {slug: this.$route.params.slug}}
        },
        getUrlFaleConosco(){
            return { name:'FaleConoscoForm', params: {slug: this.$route.params.slug}};
        }
    }
}
</script>
<style lang="scss" scoped>

</style>
