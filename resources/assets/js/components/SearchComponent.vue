<template>
    <form  v-on:submit.prevent="onSearch">
        <div class="input-group">
            <input type="text" class="form-control" v-bind:placeholder="placeholder" >
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
            placeholder: 'Busque em nosso repositorio de conteúdos'
        }
    },
    methods:{
        onSearch: function (){
            console.log('sad');
        }
    }
}
</script>
<style lang="sass" scoped>

</style>

