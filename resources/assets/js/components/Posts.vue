<template>
    <div>
        <section v-for="(item, i) in posts" :key="i">
            <PaginatorCard v-bind:item="item"></PaginatorCard>
        </section>
    </div>
</template>
<script>
import { mapState } from "vuex";
import PaginatorCard from "./PaginatorCard.vue";

export default {
  name: "Posts",
  components: { PaginatorCard },
  computed: {
    ...mapState(["posts"])
  }
};
</script>
<style lang="scss" scoped>
</style>