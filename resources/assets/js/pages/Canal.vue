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
                    <h1 class="page-title" v-bind:style="`--color:${color}`" v-bind:stylepseudo="`after:`">{{ title }}</h1>
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
                        <router-view v-bind:color="color"></router-view>
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
            options: null,
            color: '#1e78c2'
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
            this.options = JSON.parse(resp.data.canal.options)
            this.color = this.options.color;
            
            localStorage.setItem('idCanal', this.idCanal);
        }
    }
}
</script>
<style lang="scss" scoped>
.page-header { margin : 0; }
.page-header > h1 { font-size: 22px;}
.page-header .page-title {
    margin-top: 0;
    position: relative;
    margin-bottom: 30px;
}
.page-header .page-title:after {
    
    width: 25%;
    height: 2px;
    content: '';
    background: var(--color);
    display: block;
    position: absolute;
    bottom: -10px;
}
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