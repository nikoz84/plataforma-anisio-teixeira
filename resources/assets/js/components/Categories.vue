<template>
    <nav role="menu categorias" v-if="categories">
        <ul class="nav nav-pills nav-stacked">
            <router-link tag="li" :to="{ name: 'Listar', params: { slug : $route.params.slug }}" class="active">
                Todos
            </router-link>
            <!-- CATEGORIAS -->
            <li v-for="(category, c) in categories" v-bind:key="c">
                <router-link :to="{ name: 'Listar', 
                            params: { slug : $route.params.slug }, 
                            query: { categoria: category.id }}" exact class="categoria">
                <a class="link">{{ category.name }}</a>
                </router-link>
                <!-- SUBCATEGORIAS -->
                <ul v-if="category.sub_categories && category.sub_categories.length > 0">
                    <li v-for="(subcategory, s) in category.sub_categories" v-bind:key="s" class="sub-categoria">
                        <router-link :to="{ name: 'Listar', 
                            params: { slug : $route.params.slug }, 
                            query: { categoria: subcategory.id }}" exact >
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
<style lang="scss" scoped>

.categoria{
  border: 1px solid rgb(231, 230, 230);
  background-color: rgb(233, 233, 233);
  margin-bottom: 2px;
}

.sub-categoria{
  border: 1px solid rgb(231, 230, 230);
  background-color: rgb(243, 242, 242);
  padding: 10px 5px 5px;
  margin-bottom: 2px;

}

.active{
  background-color: rgb(131, 133, 134) !important;
  color: #fff;
  padding: 10px;
  font-weight: bold;
}

ul{
    list-style-type: none;
}
</style>

