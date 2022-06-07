<template>
<component :is="$route.meta.layout">
  <router-view name="main"></router-view>
</component>
</template>

<script>
export default {
    name: "Main",
    mounted() {
      //this.$q.dark.set(true) 
      //console.log(this.$q.dark.mode)
    },
}
</script>

<style>

</style>