<template>
    <h1 class="text-h6" color="black" v-html="title"></h1>
</template>
<script>
export default {
  name: "Title",
  props: ["title"]
};
</script>
