<template>
    <nav role="menu categorias" v-if="categories">
        <ul class="list-unstyled list-group">
            <!-- TODOS -->
            <router-link tag="li" :to="{ name: 'Listar', params: { slug : $route.params.slug }}" class="active">
                <a class="list-group-item">Todos</a>
            </router-link>
            <!-- CATEGORIAS -->
            <li v-for="(category, c) in categories" v-bind:key="c">
            <router-link :to="{ name: 'Listar', 
                        params: { slug : $route.params.slug }, 
                        query: { categoria: category.id }}" exact>
                <a class="list-group-item" v-text="category.name"></a>
            </router-link>
            
                <!-- SUBCATEGORIAS -->
                <ul class="list-unstyled list-group" v-if="category.sub_categories && category.sub_categories.length > 0" >
                    <li v-for="(subcategory, s) in category.sub_categories" v-bind:key="s">
                        <router-link :to="{ name: 'Listar', 
                            params: { slug : $route.params.slug }, 
                            query: { categoria: subcategory.id }}" exact >
                        <a class="list-group-item" v-text="subcategory.name"></a>
                        </router-link>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</template>
<script>
import {mapState} from 'vuex';

export default {
    name: "Categories",
    computed: {
        ...mapState(["categories"])
    },
}
</script>
<style lang="scss" scoped>

</style>

