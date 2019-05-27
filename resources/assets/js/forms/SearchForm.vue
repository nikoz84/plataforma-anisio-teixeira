<template>
    <form class="search pull-right" v-on:submit.prevent="onSearch()" style="max-width:350px;">
        <div class="input-group">
            <input type="text" 
                    id="termo" 
                    class="form-control input-sm" 
                    v-model="termo" 
                    placeholder="Pesquisar...">
            <span class="input-group-btn">
                <button class="btn btn-default btn-sm" type="submit">Pesquisa</button>
            </span>
        </div>
    </form>
</template>
<script>
import debounce from 'lodash/debounce';
import { mapMutations} from 'vuex';

export default {
    name : 'SearchForm',
    data() {
        return {
            termo: '',
        }
    },
    created(){
        this.delayFunction = debounce(this.onSearch,500);
    },
    watch:{
        termo(novo, antigo){
            this.delayFunction();
        }
    },
    methods:{
        ...mapMutations(["SET_PAGINATOR", "SET_IS_LOADING"]),
        async onSearch(){
            if(!this.termo) return;
            
            let url = `/${this.$route.params.slug}/search/${this.termo}`;
            //this.SET_IS_LOADING(true);
            let resp = await axios.get(url);

            if(resp.data){
                //this.SET_IS_LOADING(false);
                this.SET_PAGINATOR(resp.data.paginator);
            }
        }
    }
}
</script>
<style lang="sass" scoped>

</style>

