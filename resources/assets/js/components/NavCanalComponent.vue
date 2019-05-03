<template>
    <nav>
        <ul class="nav nav-pills">
            <router-link tag="li" :to="{ name: 'Inicio', params: {slug: $route.params.slug}}" exact>
                <a>Home</a>
            </router-link>
            <router-link tag="li" :to="{ name: 'Listar', params: {slug: $route.params.slug}}">
                <a>Listar</a>
            </router-link>
            <router-link tag="li" :to="setUrlAdicionar">
                <a>Adicionar</a>
            </router-link> 
            <router-link tag="li" :to="setUrlDenuncia">
                <a>Denúnciar</a>
            </router-link> 
            <router-link tag="li" :to="setUrlFaleConosco">
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
        setUrlAdicionar(){
            if(this.$route.params.slug == 'aplicativos-educacionais'){
                return {
                    name: "EditarAplicativo",
                    params: {
                    slug: this.$route.params.slug,
                    id: this.$route.params.id,
                    action: 'adicionar'
                    }
                }
            }else {
                return {
                    name: "AdicionarConteudo",
                    params: {
                    slug: this.$route.params.slug,
                    action: 'adicionar'
                    }
                }
            }
        },
        setUrlDenuncia(){
            localStorage.setItem('urlDenuncia',location.href);
            return { name:'DenunciaForm', params: {slug: this.$route.params.slug}}
        },
        setUrlFaleConosco(){
            return { name:'FaleConoscoForm', params: {slug: this.$route.params.slug}};
        }
    }
}
</script>
<style lang="scss" scoped>

</style>
