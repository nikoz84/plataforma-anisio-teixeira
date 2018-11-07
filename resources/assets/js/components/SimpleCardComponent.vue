<template>
    <div>
        <article class="panel panel-default" v-bind:id="item.id">
            <div class="panel-body">
                <figure class="figure">
                    <!-- img width="250" height="150" src="/storage/img/default.svg" v-bind:alt="'imagem destacada'" srcset="" -->
                </figure>
                <router-link :to="{ name: 'Exibir', params: { slug: this.$route.params.slug, id: item.id }}"
                            aria-label="Título" 
                            v-bind:title="title">
                    <h4>{{ title }}</h4>
                </router-link>
                
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
    computed:{
        title(){
            return (this.item.name) ? this.item.name : this.item.title;
        }
    },
    created(){
        
    }
    
}    
</script>
<style lang="scss" scoped>

.panel-default{
    border-top-color: var(--background);
    border-top-width: 3px;

}
</style>
