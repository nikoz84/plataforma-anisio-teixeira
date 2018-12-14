<template>
    <section>
        <h1>{{ title }}</h1>
        <p>{{ description }}</p>
    </section>
</template>
<script>

export default {
    name : 'HomeCanal',
    data() {
        return {
            title: 'Inicio',
            description: 'Aqui vai o conteúdo Inicio.'
        }
    }
}
</script>
<style lang="scss" scoped>
/**
section{
     background: var(--color); 
}
**/
</style>