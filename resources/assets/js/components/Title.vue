<template>
    <div class="text-center">
      <transition appear 
                  enter-active-class="animated zoomIn"
                  leave-active-class="animated zoomOut"
                  >
        <h1 class="text-h5 title-page" v-html="title"></h1>
      </transition>
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
