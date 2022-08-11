<template>
  <div>
    <component :is="componentId" v-if="!isLoading"></component>
    <div v-else class="q-mt-lg row justify-center">
        <q-spinner-pie
            style="margin-top:80px;"
            color="primary"
            size="5em"
          />
    </div>
  </div>
</template>
<script>
import { Paginator }from "../components/paginator";
import { Posts } from "../components/blog";
import { mapState, mapActions } from "vuex";
import { QSpinnerPie } from "quasar";

export default {
  name: "Listar",
  components: { Paginator, Posts, QSpinnerPie },
  computed: {
    ...mapState(["componentId", "canal", "isLoading"])
  },
  destroy(){

  }
};
</script>
<style lang="sass" scoped>

</style>