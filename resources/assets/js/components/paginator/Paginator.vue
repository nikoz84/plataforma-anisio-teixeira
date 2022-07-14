<template>
  <div>
    <div class="row justify-center q-my-lg">
      <q-pagination
          v-if="paginator && paginator.total > paginator.per_page"
          v-model="paginator.current_page"
          :max="paginator.last_page"
          :max-pages="10"
          boundary-numbers
          @input="getData"
        >
        </q-pagination>
    </div>
      <div class="row justify-center q-gutter-x-md q-gutter-y-md">
        <PaginatorCard
            class="col-xs-10 col-sm-4 col-md-3 col-lg-3 col-xl-2"
            v-for="(item, i) in paginator.data"
            :key="i"
            v-bind:item="item"
            ></PaginatorCard>
      </div>
    <div class="row justify-center q-my-lg">
      <q-pagination
          v-if="paginator && paginator.total > paginator.per_page"
          v-model="paginator.current_page"
          :max="paginator.last_page"
          :input="true"
          @input="getData"
        >
        </q-pagination>
    </div>
  </div>
</template>

<script>
import { mapState, mapMutations } from "vuex";
import PaginatorCard from "./PaginatorCard.vue";

export default {
    name: "Paginator",
    components: {
      PaginatorCard
    },
    computed: {
        ...mapState(["paginator"])
    },
    methods: {
        ...mapMutations(["SET_PAGINATOR"]),
        async getData(page){
          this.$q.loading.show()
          console.log(page)
          const {data} = await axios.get(this.paginator.path + `&page=${page}`);
          if(data.success){
            this.SET_PAGINATOR(data.paginator);
          }
          this.$q.loading.hide()
        }
    },
}
</script>

<style>

</style>