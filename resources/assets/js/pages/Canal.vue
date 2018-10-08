<template>
    <div>
        <h1>{{ title }} {{ $route.params.slug }}</h1>
        <router-view></router-view>
        <aside>
            <nav>
                <router-link :to="{ name: 'Inicio', params: {slug: $route.params.slug}}">Inicio</router-link> |
                <router-link :to="{ name: 'Sobre', params: {slug: $route.params.slug}}">Sobre</router-link> |
                <router-link :to="{ name: 'Listar', params: {slug: $route.params.slug}}">Listar</router-link>

                
            </nav>
        </aside>
    </div>
</template>
<script>

export default {
    name : 'canal',
    data() {
        return {
            title: 'Canal'
        }
    }
}
</script>
<style lang="sass" scoped>

</style>