<template>
  <component :is="$route.meta.layout">
    <router-view name="main"></router-view>
  </component>
</template>

<script>
export default {
  name: "Main",
};
</script>
