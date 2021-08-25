<template>
  <div v-if="errors">
    <p class="text-negative" v-for="error in errors" v-html="error"></p>
  </div>
</template>
<script>
export default {
  name: "ShowErrors",
  props: ["errors"],
  
};
</script>
