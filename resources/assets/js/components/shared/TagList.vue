<template>
  <div>
    <strong >{{title}}:</strong>
    <q-chip flat 
      dense
      color="blue-grey-6" 
      text-color="white"
      clickable
      v-for="(item, i) in items"
      :key="i"
      :label="item.name"
      @click="searchBy(item)"
    >
      <q-tooltip content-class="bg-grey-10" content-style="font-size: 12px">
        Procurar por palavra-chave: {{item.name}}
      </q-tooltip>
    </q-chip>
  </div>    
</template>
<script>
export default {
  name: "TagList",
  props: ["items", "title", "slug"],
  methods: {
    searchBy(item) {
      let term = this.slug == "busca" ? item.name : item.id;
      let url = `/recursos-educacionais/listar?${this.slug}=${term}`;

      this.$router.push(url);
    }
  }
};
</script>

