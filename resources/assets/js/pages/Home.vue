<template>
    <div>
        <h1>{{ title }}</h1>
        <p>{{ description }}</p>
    </div>
</template>
<script>

export default {
    name : 'home',
    data() {
        return {
            title: 'Inicio',
            description: 'Aqui vai o conteúdo Inicio.'
        }
    }
}
</script>
<style lang="sass" scoped>

</style>