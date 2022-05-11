<template>
  <div>
    <strong >{{title}}:</strong>
    <div class="flex justify-center q-mt-md wordbreak">
    <a v-for="(item, i) in items"
      :key="`tag-${i}`"
      class="q-ml-lg q-mt-md tag"
      v-html="item.name"
      :href="searchBy(item)"      
      :title="`Procurar por palavra-chave: ${item.name}`"
    >
      
    </a>
    </div>
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

      return url;
    }
  }
};
</script>