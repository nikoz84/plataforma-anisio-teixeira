<template>
    <div>
        <List v-bind:items="paginator.data"></List>
        <Paginator v-bind:paginator="paginator"></Paginator>
    </div>
</template>
<script>
import List from '../components/ListComponent.vue';
import Paginator from '../components/PaginatorComponent.vue';


export default {
    name : 'listar',
    components:{ List, Paginator },
    props:['idCanal'],
    data() {
        return {
            title: 'Listar',
            url : null,
            paginator: {}
        }
    },
    created() {
        this.getConteudos();
        
    },
    methods:{
        getConteudos(){
            let idCanal = localStorage.getItem('idCanal');
            let url = this.getUrl(idCanal);
            console.log(url);
            axios.get(url).then(resp =>{
                  console.log(resp);
                  this.title = resp.data.title;
                  this.paginator = resp.data.paginator;
                  
                });
        },
        getUrl(canal){
            
            switch(true){
                case (canal == 5):
                    return `/api-v1/conteudos?site=true`;
                break;
                case (canal == 9):
                    return `/api-v1/aplicativos`;
                break;
                default:
                    return `/api-v1/conteudos?canal=${canal}`;     
            }
            
        }
    }
}
</script>
<style lang="sass" scoped>

</style>