<template>
  <div class="row">
    <header class="page-header col-12">
      <Title title="Administração da Plataforma"></Title>
    </header>
    <section class="col-12">
      <router-view name="admin"></router-view>
    </section>
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
