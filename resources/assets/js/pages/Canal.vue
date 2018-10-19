<template>
    <div class="row">
        <aside class="col-sm-3">
            sidebar
        </aside>
        <article class="col-sm-9">
            <header class="page-header">
                <h1><small>{{ title }}</small></h1>
                <nav>
                    <router-link :to="{ name: 'Inicio', params: {slug: $route.params.slug}}">Home</router-link> |
                    <router-link :to="{ name: 'Listar', params: {slug: $route.params.slug}}">Programas</router-link> |
                    <router-link :to="{ name: 'Sobre', params: {slug: $route.params.slug}}">Sobre</router-link>
                </nav>
            </header>
            <router-view v-bind:id="idCanal"></router-view>
        </article>
    </div>
</template>
<script>

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
        getCanal(){
            axios.get(`/api-v1/canais/slug/${this.$route.params.slug}`).then(resp =>{
                this.idCanal = resp.data.canal.id;
                this.title = resp.data.canal.name;
                localStorage.setItem('idCanal', this.idCanal);
                //this.descricao = resp.data.canal.description;
                //this.pagina = this.$route.name;
                //this.metaData = JSON.parse(resp.data.canal.options);
                //console.log(resp.data.canal)
            });
        },
    }
}
</script>
<style lang="sass" scoped>

</style>