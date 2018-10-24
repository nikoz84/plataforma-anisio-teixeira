<template>
    <nav>
        <ul class="nav nav-pills nav-stacked">
            <router-link tag="li" :to="{ name: 'Listar', params: {slug: $route.params.slug, category: 'categoria'}}">
                <a>Categoria 1</a>
            </router-link> 
        </ul>    
    </nav>
</template>
<script>
export default {
    name : 'SidebarCanal',
    
}
</script>
<style lang="scss" scoped>

</style>
