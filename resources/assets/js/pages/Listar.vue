<template>
    <div>
        <component :is="componentId" v-if="!isLoading"></component>
        <Loader v-else></Loader>
        
    </div>
</template>
<script>
import Loader from '../components/Loader.vue';
import Paginator from "../components/Paginator.vue";
import Posts from "../components/Posts.vue";
import { mapState, mapActions } from 'vuex';

export default {
  name: "Listar",
  components: { Paginator, Posts, Loader},
  computed: {
    ...mapState(["componentId", "isLoading", "canal"])
  },
  methods: {},
};
</script>
<style lang="sass" scoped>

</style>