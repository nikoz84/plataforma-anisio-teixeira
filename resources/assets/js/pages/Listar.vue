<template>
    <div>
        
        <!-- keep-alive -->
            <lista></lista>
        <!--/keep-alive -->
            
        
    </div>
</template>
<script>
import Lista from '../components/ListComponent.vue';
import {mapGetters, mapActions} from 'vuex';
import client from '../client.js';

export default {
    name : 'Listar',
    components:{ lista: Lista },
    props:['color'],
    data() {
        return {
            
        }
    },
    created() {
        this.$store.dispatch('getConteudos', localStorage.canal_id)
        
    },
    watch: {
        '$route' (to, from) {
            this.$store.getters.getByIdCanal(localStorage.canal_id);
            console.log(this.$store.getters.getCount);
            
        }
    },
    methods:{
        
    },
    computed:{
        ...mapGetters(['paginator','getCount','getByIdCanal']),
        ...mapActions(['getConteudos'])
    }
}
</script>
<style lang="sass" scoped>

</style>