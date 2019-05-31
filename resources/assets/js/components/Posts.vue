<template>
    <div>
        <section v-for="(item, i) in posts" :key="i">
            <SimpleCard v-bind:item="item"></SimpleCard>
        </section>
    </div>
</template>
<script>
import { mapState } from "vuex";
import SimpleCard from "./SimpleCard.vue";

export default {
  name: "Posts",
  components: { SimpleCard },
  computed: {
    ...mapState(["posts"])
  }
};
</script>
<style lang="scss" scoped>
</style>