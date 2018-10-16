<template>
    <div>
        <h1>{{ title }} {{ $route.params.slug }}</h1>
        <router-view></router-view>
        <aside>
            <nav>
                <router-link :to="{ name: 'Inicio', params: {slug: $route.params.slug}}">Inicio</router-link> |
                <router-link :to="{ name: 'Sobre', params: {slug: $route.params.slug}}">Sobre</router-link> |
                <router-link :to="{ name: 'Listar', params: {slug: $route.params.slug}}">Listar</router-link>

                
            </nav>
        </aside>

        <ul v-for="(item, i) in paginator.data" v-bind:key="i">
            <li v-bind:id="item.id">
                {{ item.title }}
            </li>
        </ul>
        {{paginator.last_page}}
        <a v-bind:href="paginator.last_page_url">{{ paginator.last_page_url }}</a>
    </div>
</template>
<script>

export default {
    name : 'canal',
    data() {
        return {
            title: null,
            urlProximaPagina: null,
            //paginator: {}
        }
    },
    mounted() {
        this.getConteudos();
    },
    watch: {
        '$route' (to, from) {
            this.getConteudos()
        }
    },
    methods:{
        getConteudos(){
            console.log(this.$route.params.slug)
            axios.get(`/api-v1/conteudos`, {canal_id : 1}).then(resp =>{
                console.log(resp.data.paginator)
                if(resp.data.paginator){
                    this.urlProximaPagina = resp.data.paginator.next_page_url;
                }
                //this.paginator = resp.data.paginator;
                //this.title = resp.data.title;
            })

        }
    }
}
</script>
<style lang="sass" scoped>

</style>