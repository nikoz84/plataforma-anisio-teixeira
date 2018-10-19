<template>
    <div>
        <List v-bind:items="paginator.data"></List>
    </div>
</template>
<script>
import List from '../components/ListComponent.vue';


export default {
    name : 'listar',
    components:{ List },
    props:['idCanal'],
    data() {
        return {
            title: 'Listar',
            paginator: {}
        }
    },
    created() {
        
        console.log(localStorage.getItem('idCanal'))
        
    },
    methods:{
        getConteudos(){
            //if(this.$parent.idCanal)
            consol.log(this.$parent.idCanal)
             axios.get(`/api-v1/conteudos`, {canal_id : this.$parent.idCanal}).then(resp =>{
                  this.title = resp.data.title;
                  this.paginator = resp.data.paginator;
                });
        }
    }
}
</script>
<style lang="sass" scoped>

</style>