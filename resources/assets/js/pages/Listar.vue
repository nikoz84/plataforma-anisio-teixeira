<template>
    <div>
        <List v-bind:items="paginator.data"></List>
        <Paginator v-bind:paginator="paginator"></Paginator>
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
            paginator: {}
        }
    },
    created() {
        this.getConteudos(20,1);
        
    },
    methods:{
        async getConteudos(limit, page){
            let idCanal = localStorage.getItem('idCanal');
            let conteudos = new Http(idCanal);   
            let resp = await conteudos.getData(limit,page);

            this.title = resp.data.title;
            this.paginator = resp.data.paginator;
            
        }
    }
}
</script>
<style lang="sass" scoped>

</style>