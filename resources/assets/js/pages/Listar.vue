<template>
    <div>
        <h1>{{ title }}</h1>
        <List v-bind:items="paginator.data"></List>
    </div>
</template>
<script>
import List from '../components/ListComponent.vue';


export default {
    name : 'listar',
    components:{ List },
    data() {
        return {
            title: 'Listar',
            paginator: {}
        }
    },
    mounted() {
        this.getConteudos();
    },
    methods:{
        getConteudos(){
            console.log(this.$parent);
            console.log(this.$parent.title);
            console.log(this.$parent.idCanal);
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