<template>
    <nav>
        <ul class="nav nav-pills">
            <router-link tag="li" :to="{ name: 'Inicio', params: {slug: $route.params.slug}}" exact>
                <a>Home</a>
            </router-link>
            <router-link tag="li" :to="{ name: 'Listar', params: {slug: $route.params.slug}}">
                <a>Listar</a>
            </router-link>
            <router-link tag="li" :to="{ name: 'AdicionarConteudo', params: {slug: $route.params.slug}}" v-if="showAdicionarConteudo">
                <a>Adicionar</a>
            </router-link>
            <router-link tag="li" :to="{ name: 'AdicionarAplicativo', params: {slug: $route.params.slug}}" v-if="showAdicionarAplicativo" exact>
                <a>Adicionar</a>
            </router-link>
            <li>
                <a  v-on:click.prevent="getUrl">Denúnciar</a>
            </li>
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
        showAdicionarConteudo (){
            if(this.isLogged && this.$route.params.slug != 'aplicativos-educacionais'){
                return true;
            }
            return false;
        },
        showAdicionarAplicativo (){
            if(this.isLogged && this.$route.params.slug == 'aplicativos-educacionais'){
                return true;
            }
            return false;
        }
    },
    methods:{
        getUrl(){
            let url = encodeURI(location.href);
            this.$router.push(
                { name:'DenunciaForm', params: {slug: this.$route.params.slug, url}}
            )
        },
    }
}
</script>
<style lang="scss" scoped>

</style>
