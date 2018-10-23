<template>
    <div>
        <List v-bind:items="paginator.data"></List>
        <Paginator v-bind:paginator="paginator" v-bind:limit="limit" v-bind:page="page"></Paginator>
    </div>
</template>
<script>
import List from '../components/ListComponent.vue';
import Paginator from '../components/PaginatorComponent.vue';
import Http from '../http.js';


export default {
    name : 'listar',
    components:{ List, Paginator },
    props:[],
    data() {
        return {
            paginator: {},
            page: 1,
            limit: 20
        }
    },
    created() {
        this.getConteudos();
        
    },
    methods:{
        async getConteudos(){
            let idCanal = localStorage.getItem('idCanal');
            let http = new Http(idCanal);   
            let resp = await http.getDataFromIdCanal(idCanal,this.limit, this.page);

            this.title = resp.data.title;
            this.paginator = resp.data.paginator;
            this.page = resp.data.page;
            this.limit = resp.data.limit;
        }
    }
}
</script>
<style lang="sass" scoped>

</style>