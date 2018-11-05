<template>
    <div>
        <article class="panel panel-default" v-bind:id="item.id">
            <div class="panel-body">
                <figure class="figure">
                    <!-- img width="250" height="150" src="/storage/img/default.svg" v-bind:alt="'imagem:' + item.title" srcset="" -->
                </figure>
                <router-link :to="{ name: 'Exibir', params: { slug: this.$route.params.slug, id: item.id }}">
                    ir
                </router-link>
                <h4>{{ (item.name) ? item.name : item.title }}</h4>
            </div>
        </article>
    </div>
</template>
<script>

export default {
    name: 'SimpleCard',
    props:{
        item: Object
    },
    created(){
        console.log('sdf')
    }
    
}    
</script>
<style lang="scss" scoped>

.panel-default{
    border-top-color: var(--background);
    border-top-width: 3px;

}
</style>
