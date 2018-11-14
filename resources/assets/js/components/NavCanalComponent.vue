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
            <router-link tag="li" :to="{ name: 'AdicionarConteudo', params: {slug: $route.params.slug}}" v-if="$route.params.slug != 'aplicativos-educacionais'">
                <a>Adicionar</a>
            </router-link>
            <router-link tag="li" :to="{ name: 'AdicionarAplicativo', params: {slug: $route.params.slug}}" v-else>
                <a>Adicionar</a>
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
