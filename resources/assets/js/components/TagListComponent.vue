<template>
    <div>
        <ul>
            <li v-for="(item, i) in items" v-bind:key="i">
                {{ item.name }}
            </li>
        </ul>
    </div>    
</template>
<script>
    
</script>
<style lang="scss" scoped>

</style>
