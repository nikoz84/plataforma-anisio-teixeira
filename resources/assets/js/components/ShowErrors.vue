<template>
  <div v-if="errors">
    <p v-for="(error,i) in errors" :key="i" v-text="error"></p>
  </div>
</template>
<script>
export default {
  name: "ShowErrors",
  props: ["errors"]
};
</script>
