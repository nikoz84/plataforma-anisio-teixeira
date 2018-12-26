<template>
    <div>
        
        <!-- keep-alive -->
            <List v-bind:paginator="paginator"></List>
        <!--/keep-alive -->
    </div>
</template>
<script>
import List from '../components/ListComponent.vue';
import Http from '../http.js';

const http = new Http();

export default {
    name : 'Listar',
    components:{ List },
    props:['color'],
    data() {
        return {
            paginator: {},
            title: null
        }
    },
    created() {
        this.getConteudos();
        
    },
    methods:{
        async getConteudos(){
            let idCanal = localStorage.canal_id;
            let params = {  };
            let resp = await http.getDataFromIdCanal( idCanal, params);
            
            if(resp.data.success){
                
                this.title = resp.data.title;
                this.paginator = resp.data.paginator;
            }
            
        }
    }
}
</script>
<style lang="sass" scoped>

</style>