<template>
    <div>
        <List v-bind:paginator="paginator"></List>
    </div>
</template>
<script>
import List from '../components/ListComponent.vue';
import client from '../client.js';

export default {
    name : 'Listar',
    components:{ List },
    data() {
        return {
            paginator: {},
            title: null
        }
    },
    created() {
        this.getCanais();

    },
    methods:{
        async getCanais(){
            let idCanal = localStorage.canal_id;
            let params = {  };
            let resp = await client.getDataFromIdCanal( idCanal, params);

            if(resp.data.success){

                this.title = resp.data.title;
                this.paginator = resp.data.paginator;
            }

        }
    }
}
</script>
<style lang="scss" scoped>

</style>
