<template>
  <div v-if="errors">
    <p class="text-negative" v-for="(error, i) in errors" v-html="error" :key="i"></p>
  </div>
</template>
<script>
export default {
  name: "ShowErrors",
  props: ["errors"],
  
};
</script>
