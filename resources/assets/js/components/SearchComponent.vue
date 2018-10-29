<template>
    <form class="search" v-on:submit.prevent="onSearch()" >
        <div class="input-group">
            <input type="text" class="form-control" v-bind:placeholder="placeholder" v-model="termo">
            <span class="input-group-btn">
                <button class="btn btn-default" type="submit">Pesquisa</button>
            </span>
        </div>
    </form>
</template>
<script>
import Http from '../http.js';

export default {
    name : 'Search',
    data() {
        return {
            placeholder: 'Pesquise de conteúdos',
            termo: ''
        }
    },
    methods:{
        async onSearch(){
            let url = `/${this.$parent.search}/search/${this.termo}`;
            this.$parent.show = false;
            let http = new Http();
            let resp = await http.getDataFromUrl(url);
            
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

