<template>
    <nav>
        <ul class="nav nav-pills nav-stacked">
            <router-link tag="li" :to="{ name: 'Listar', query: { category: 'todos'}}" exact>
                <a>Todos</a>
            </router-link>
            <router-link tag="li" :to="{ name: 'Listar', query: { category: '1'}}" exact>
                <a>Matematicas</a>
            </router-link>
            <li v-for="(category, c) in categories" v-bind:key="c">
                {{ category.name }}
                <ul>
                    <li v-for="(subcategory, s) in category.sub_categories" v-bind:key="s" v-if="subcategory.options.is_active">
                        {{ subcategory.name }}
                    </li>
                </ul>
            </li>
        </ul>    
    </nav>
</template>
<script>
import Http from '../http.js';

const http = new Http;

export default {
    name : 'SidebarCanal',
    props:['categories']
}
</script>
<style lang="scss" scoped>

</style>
