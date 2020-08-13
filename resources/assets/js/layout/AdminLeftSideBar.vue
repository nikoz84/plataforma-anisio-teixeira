<template>
  <q-list>
    <q-item-label class="bg-grey-4" header>
      <strong class="grey-10">
        Painel de Controle
      </strong>
    </q-item-label>
    <q-item
        to="/admin/resumo/listar"
        aria-label="Resumo da pat"
        title="Resumo da pat"
        clickable
        tabindex="0"
        active-class="active-link-pat"
        exact
      >
        <q-item-section>
          <q-item-label>Resumo</q-item-label>
        </q-item-section>
    </q-item>
    <q-separator />
    <div v-for="(link, i) in linksAdmin" :key="`admin-${i}`">
      <q-item
        tag="div"
        :to="`/admin/${link.slug}/listar`"
        
        :aria-label="`IR: ${link.label}`"
        :title="`IR: ${link.label}`"
        clickable
        tabindex="0"
        active-class="active-link-pat"
        exact
      >
        <q-item-section>
          <q-item-label>{{ link.label }}</q-item-label>
        </q-item-section>
      </q-item>
      <q-separator />
    </div>
  </q-list>
</template>
<script>
import {mapState, mapActions} from 'vuex';

export default {
  name: "AdminLeftSideBar",
  computed: {
    ...mapState(['linksAdmin', 'isLogged'])
  },
  mounted() {
    this.getLinksAdmin();
  },
  methods: {
    ...mapActions(['getLinksAdmin']),
    
  }
};
</script>
