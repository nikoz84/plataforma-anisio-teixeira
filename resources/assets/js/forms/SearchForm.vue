<template>
    <form class="search" v-on:submit.prevent="onSearch()" >
        <div class="input-group">
            <input type="text" id="termo" class="form-control" v-model="termo" :placeholder="placeholder">
            <span class="input-group-btn">
                <button class="btn btn-default" type="submit">Pesquisa</button>
            </span>
        </div>
    </form>
</template>
<script>
import client from '../client.js';
import debounce from 'lodash/debounce'


export default {
    name : 'SearchForm',
    props: ['search'],
    data() {
        return {
            placeholder: 'Pesquise...',
            termo: ''
        }
    },
    created(){
        this.delayFunction = debounce(this.onSearch,500);
    },
    watch:{
        termo(novo, antigo){
            this.placeholder = 'Esperando...';
            this.delayFunction();
        }
    },
    methods:{
        async onSearch(){
            if(!this.termo) return;
            let url = `/${this.search}/search/${this.termo}`;
            this.$parent.show = false;
            
            let params ={ token: localStorage.token };
            let resp = await client.getDataFromUrl(url, params);

            if(resp.data){
                this.$parent.paginator = resp.data.paginator;
                this.$parent.show = true;
            }

        }
    }
}
</script>
<style lang="sass" scoped>

</style>

