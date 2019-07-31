<template>
  <div>
    <component :is="componentId" v-if="!isLoading"></component>
    <div v-else class="q-mt-lg row justify-center" style="font-size: 8em">
       <q-spinner-tail color="blue-grey" />
    </div>
  </div>
</template>
<script>
import Paginator from "../components/Paginator.vue";
import Posts from "../components/Posts.vue";
import { mapState, mapActions } from "vuex";
import { QSpinnerTail } from "quasar";

export default {
  name: "Listar",
  components: { Paginator, Posts, QSpinnerTail },
  computed: {
    ...mapState(["componentId", "isLoading", "canal"])
  },
  methods: {}
};
</script>
<style lang="sass" scoped>

</style>