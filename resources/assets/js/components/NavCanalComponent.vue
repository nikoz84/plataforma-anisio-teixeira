<template>
    <nav>
        <ul class="nav nav-pills">
            <router-link tag="li" :to="{ name: 'Inicio', params: {slug: $route.params.slug}}">
                <a>Home</a>
            </router-link> 
            <router-link tag="li" :to="{ name: 'Listar', params: {slug: $route.params.slug}}">
                <a>Listar</a>
            </router-link> 
            <router-link tag="li" :to="{ name: 'Sobre', params: {slug: $route.params.slug}}">
                <a>Sobre</a>
            </router-link>
        </ul>    
    </nav>
</template>
<script>
export default {
    name : 'NavCanal',
    
}
</script>
<style lang="scss" scoped>

</style>
