<template>
  <q-list>
    <q-item-label class="bg-grey-4" header>
      <div
        class="text-h6 text-primary"
        style="font-family: 'Concert One', sans-serif, cursive;"
      >
        Configurações
      </div>
    </q-item-label>
    <div v-for="(link, i) in links" :key="`admin-${i}`">
      <q-item
        tag="div"
        :to="{ name: link.view, params: link.params, path: '/admin' }"
        :aria-label="`endereço para: ${link.name}`"
        :title="`endereço para: ${link.name}`"
        clickable
        v-close-popup
        tabindex="0"
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
export default {
  name: "AdminLeftSideBar",
  data() {
    return {
      links: []
    };
  },
  mounted() {
    this.getUser();
  },
  methods: {
    async getUser() {
      let resp = await axios.get("/auth/user");
      if (resp.data.success) {
        this.links = resp.data.metadata.links;
      }
    }
  }
};
</script>
