<template>
    <div>
        ASDASD
    </div>
</template>
<script>
import client from '../client.js';

export default {
    name : 'Listar',
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
            console.warn('LISTADMINCOMP')

        }
    }
}
</script>
<style lang="scss" scoped>

</style>
