<template>
    <div>
        
        <!-- keep-alive -->
            <List v-bind:paginator="paginator"></List>
        <!--/keep-alive -->
    </div>
</template>
<script>
import List from '../components/ListComponent.vue';
import client from '../client.js';

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
    watch: {
        '$route' (to, from) {
            this.getConteudos();
        }
    },
    methods:{
        async getConteudos(){
            console.log(this.$route.query)
            let params = this.$route.query;
            
            let resp = await client.get('/conteudos', params );
            console.log(resp)
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