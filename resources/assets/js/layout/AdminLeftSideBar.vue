<template>
  <q-list>
    <q-item-label class="bg-grey-4" header>
      <strong class="grey-10">
        Painel de Controle
      </strong>
    </q-item-label>
    <div v-for="(link, i) in linksAdmin" :key="`admin-${i}`">
      <q-item
        tag="div"
        :to="{ name: link.view, params: link.params, path: '/admin' }"
        :aria-label="`endereço para: ${link.name}`"
        :title="`endereço para: ${link.name}`"
        clickable
        v-close-popup
        tabindex="0"
        v-if="link && link.view"
        exact
        active-class="active-pat"
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
