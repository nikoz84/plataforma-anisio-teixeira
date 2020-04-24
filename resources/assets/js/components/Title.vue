<template>
    <h1 class="text-h5" v-html="title"></h1>
</template>
<script>
import { QSeparator } from "quasar";

export default {
  name: "Title",
  props: ["title"],
  components: { QSeparator }
};
</script>
