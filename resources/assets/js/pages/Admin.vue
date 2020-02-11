<template>
  <div class="q-pa-md">
    <router-view name="admin"></router-view>
  </div>
</template>
<script>
import { mapState } from "vuex";
import { QTabs, QRouteTab, QSeparator } from "quasar";
import Title from "../components/Title.vue";

export default {
  name: "admin",
  components: {
    QTabs,
    QRouteTab,
    QSeparator,
    Title
  },
  data() {
    return {};
  }
};
</script>
<style lang="scss" scoped>
.page-header {
  margin-top: 0px;
}
</style>
