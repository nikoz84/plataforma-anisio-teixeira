<template>
    <div>
        <q-card>
          <q-card-section>
            klasklsdkld
          </q-card-section>
        </q-card>
        <section v-for="(item, i) in posts" :key="i">
            <PaginatorCard v-bind:item="item"></PaginatorCard>
        </section>
    </div>
</template>
<script>
import { mapState } from "vuex";
import { PaginatorCard } from "@components/paginator";

export default {
  name: "Posts",
  components: { PaginatorCard },
  computed: {
    ...mapState(["posts"])
  }
};
</script>