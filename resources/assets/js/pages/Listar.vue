<template>
    <div>
        <lista></lista>
    </div>
</template>
<script>
import Lista from '../components/ListComponent.vue';
import {mapGetters, mapActions, mapMutations} from 'vuex';
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
            console.log(this.$store.getters.getError)
            
        }
    },
    methods:{
        
    },
    computed:{
        ...mapGetters(['paginator','getCount','getByIdCanal','getError'])
    }
}
</script>
<style lang="sass" scoped>

</style>