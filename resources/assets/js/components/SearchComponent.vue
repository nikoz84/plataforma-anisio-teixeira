<template>
    <form  v-on:submit.prevent="onSearch()" >
            <div class="input-group">
                <input type="text" class="form-control" v-bind:placeholder="placeholder" v-model="termo">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Pesquisa</button>
                </span>
            </div>
    </form>
</template>
<script>

export default {
    name : 'Search',
    data() {
        return {
            placeholder: 'Pesquise de conteúdos',
            termo: ''
        }
    },
    methods:{
        onSearch: function (){
            let url = `/api-v1/${this.$parent.search}/search/${this.termo}`;
            console.log(url);
            axios.get(url).then(resp => {
                console.log(resp)
            }).catch(error=>{
                console.log(error.response)
            })
        }
    }
}
</script>
<style lang="sass" scoped>

</style>

