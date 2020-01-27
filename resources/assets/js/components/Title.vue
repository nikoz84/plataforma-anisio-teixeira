<template>
    <div class="text-h5 text-center">
        {{ title }}
        <q-separator class="q-my-lg" />
    </div>
</template>
<script>
import { QSeparator } from "quasar";

export default {
  name: "Title",
  props: ["title"],
  components: { QSeparator }
};
</script>
