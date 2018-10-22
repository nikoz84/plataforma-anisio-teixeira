<template>
    <article class="panel panel-default" v-bind:id="item.id">
        <div class="panel-body">
            <figure class="figure">
                <img width="250" height="150" src="/storage/img/default.svg" v-bind:alt="'imagem:' + item.title" srcset="">
            </figure>
            <h4>{{ (item.name) ? item.name : item.title }}</h4>
            
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
<style lang="scss" scoped>
.figure{
    
}
</style>
