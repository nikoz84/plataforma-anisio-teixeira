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

        <!-- section class="col-sm-3">
            <div>
                <ul class="list-unstyled" v-if="paginator.data" v-for="(item, i) in paginator.data" :key="i">
                    <li class="panel panel-default" v-bind:id="item.id">
                        <div class="panel-body">

                            <h4>{{ (item.name) ? item.name : item.title }}</h4>

                        </div>
                    </li>
                </ul>
            </div>
            <Paginator v-bind:paginator="paginator"></Paginator>
        </section-->
    </div>
</template>
<script>

export default {
    name : 'canal',
    data() {
        return {
            title: null,
            urlProximaPagina: null,
            idCanal: null,
            paginator:{}
        }
    },
    created(){
        console.log('componente criado')
    },
    mounted() {
        console.log('componente montado: ', this.$route.params.slug);
        this.getCanal();
    },
    watch: {
        '$route' (to, from) {
            //this.getConteudos()
            console.log('mudança do router ', this.$route.params.slug)
            this.getCanal();
        }
    },
    methods:{
        getConteudos(){
            axios.get(`/api-v1/conteudos`, {canal_id : this.idCanal}).then(resp =>{
                console.log(resp.data)
                /*
                if(resp.data.paginator){
                    this.urlProximaPagina = resp.data.paginator.next_page_url;
                }
                this.paginator = resp.data.paginator;
                this.title = resp.data.title;
                */
            });
        },
        getCanal(){
            axios.get(`/api-v1/canais/slug/${this.$route.params.slug}`).then(resp =>{
                this.idCanal = resp.data.canal.id;
                this.getConteudos();
                //console.log(JSON.parse(resp.data.canal.options))
                console.log(resp.data.canal)
            });
        },
    }
}
</script>
<style lang="sass" scoped>

</style>