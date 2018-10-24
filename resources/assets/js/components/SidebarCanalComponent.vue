<template>
    <nav>
        <ul class="nav nav-pills nav-stacked">
            <router-link tag="li" :to="{ name: 'Listar', query: { category: 'todos'}}">
                <a>Todos</a>
            </router-link>
            <router-link tag="li" :to="{ name: 'Listar', query: { category: '1'}}">
                <a>Matematicas</a>
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
