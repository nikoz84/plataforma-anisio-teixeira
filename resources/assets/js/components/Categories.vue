<template>
    <nav role="menu categorias" v-if="categories">
        <ul class="nav nav-pills nav-stacked">
            <router-link tag="li" :to="{ name: 'Listar', params: { slug : $route.params.slug }}">
                <a>Todos</a>
            </router-link>
            <!-- CATEGORIAS -->
            <li v-for="(category, c) in categories" v-bind:key="c">
                <router-link :to="{ name: 'Listar', 
                            params: { slug : $route.params.slug }, 
                            query: { categoria: category.id }}" exact>
                <a>{{ category.name }}</a>
                </router-link>
                <!-- SUBCATEGORIAS -->
                <ul v-if="category.sub_categories && category.sub_categories.length > 0">
                    <li v-for="(subcategory, s) in category.sub_categories" v-bind:key="s" >
                        <router-link :to="{ name: 'Listar', 
                            params: { slug : $route.params.slug }, 
                            query: { categoria: subcategory.id }}" exact>
                        <a>{{ subcategory.name }}</a>
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

