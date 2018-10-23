<template>
    <section class="container-fluid heigth">
        <div class="row">
            <aside class="col-sm-3">
                <header>Categorias</header>
                <ul>
                    <li>categoria 1</li>
                    <li>categoria 2</li>
                    <li>categoria 3</li>
                    <li>categoria 4</li>
                </ul>
            </aside>
            <article class="col-sm-9">
                <header class="page-header">
                    <h1><small>{{ title }}</small></h1>
                    <nav>
                        <router-link :to="{ name: 'Inicio', params: {slug: $route.params.slug}}">
                            <a>Home</a>
                        </router-link> |
                        <router-link :to="{ name: 'Listar', params: {slug: $route.params.slug}}">
                            <a>Listar</a>
                        </router-link> |
                        <router-link :to="{ name: 'Sobre', params: {slug: $route.params.slug}}">
                            <a>Sobre</a>
                        </router-link>
                    </nav>
                </header>
                <section>
                    <transition name="fade" mode="out-in">
                        <router-view></router-view>
                    </transition>
                </section>
                    
            </article>
        </div>
    </section>
</template>
<script>
import Http from '../http.js';

export default {
    name : 'canal',
    data() {
        return {
            title: null,
            descricao: null,
            idCanal: null,
            metaData: null
        }
    },
    created() {
        
    },
    mounted() {
        this.getCanal();
    },
    watch: {
        '$route' (to, from) {
            this.getCanal();
        }
    },
    methods:{
        async getCanal(){
            let url = `/canais/slug/${this.$route.params.slug}`; 
            let canal = new Http();
            let resp = await canal.getDataFromUrl(url);
            
            this.idCanal = resp.data.canal.id;
            this.title = resp.data.canal.name;
            localStorage.setItem('idCanal', this.idCanal);
        }
    }
}
</script>
<style lang="scss" scoped>
.page-header { margin-top: 0px; }
.page-header > h1 { margin-top: 0px; }
.fade-enter {
  opacity: 0;
}
.fade-enter-active {
  transition: opacity 1s ease;
}
.fade-leave {}
.fade-leave-active {
  transition: opacity 1s ease;
  opacity: 0;
}
</style>