<template>
  <q-list dense bordered padding separator>
    <q-item-label class="bg-grey-4" header>
      <strong class="grey-10">
        Painel de Controle
      </strong>
    </q-item-label>
    <ReportsMenu></ReportsMenu>
    <q-item
      to="/admin/resumo/listar"
      aria-label="Resumo da pat"
      title="Resumo da pat"
      clickable
      tabindex="0"
      active-class="active-link-pat"
    >
      <q-item-section>
        <q-item-label>Resumo</q-item-label>
      </q-item-section>
    </q-item>

    <q-item
      v-for="(link, i) in linksAdmin"
      :key="`admin-${i}`"
      :to="`/admin/${link.slug}/listar`"
      :aria-label="`IR: ${link.label}`"
      :title="`IR: ${link.label}`"
      clickable
      tabindex="0"
      active-class="active-link-pat"
    >
      <q-item-section>
        <q-item-label>{{ link.label }}</q-item-label>
      </q-item-section>
    </q-item>
  </q-list>
</template>
<script>
import { mapState, mapActions } from "vuex";
import { ReportsMenu } from "@/components/shared";

export default {
  name: "AdminLeftSideBar",
  components: {
    ReportsMenu,
  },
  computed: {
    ...mapState(["linksAdmin", "isLogged"]),
  },
  mounted() {
    this.getLinksAdmin();
  },
  methods: {
    ...mapActions(["getLinksAdmin"]),
  },
};
</script>
