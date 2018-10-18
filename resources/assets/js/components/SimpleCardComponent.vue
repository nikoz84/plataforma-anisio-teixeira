<template>
    <article class="panel panel-default" v-bind:id="item.id">
        <div class="panel-body">
            <h4>{{ (item.name) ? item.name : item.title }}</h4>
            <div class="pull-right">
                <a class="text-default">editar</a>
                <a class="text-danger">deletar</a>
            </div>
        </div>
    </article>
</template>
<script>

export default {
    name: 'SimpleCard',
    props:{
        item: Object
    }
    
}    
</script>
<style lang="sass" scoped>

</style>
