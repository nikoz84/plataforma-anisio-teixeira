<template>
  <q-btn-dropdown
        stretch 
        dropdown-icon="arrow_drop_down" 
        flat 
        :label="canal.category_name"
        v-if="canal && categories && categories.length > 0">
    
      <q-list dense>
        <q-item clickable dense 
              v-for="(category, i) in categories" 
              :key="i"
              v-close-popup="category.sub_categories.length == 0"
              @click="showCategory(category.id, category.sub_categories)">
          <q-item-section>{{category.name}}</q-item-section>
          <q-item-section side v-if="category.sub_categories && category.sub_categories.length > 0">
            <q-icon name="keyboard_arrow_right" />
          </q-item-section>

          <q-menu anchor="center middle" self="center middle" v-if="category.sub_categories">
            <q-list>
              <q-item v-for="(subcategory,n) in category.sub_categories" 
                      :key="n" 
                      clickable
                      dense
                      v-close-popup
                      @click="showCategory(subcategory.id, 'sub')">
                <q-item-section>
                  {{subcategory.name}}
                </q-item-section>
              </q-item>
            </q-list>
          </q-menu>
        </q-item>
      </q-list>
  </q-btn-dropdown>
</template>
<script>
import { QTab, QMenu, QList, QItem, QItemSection, ClosePopup } from "quasar";
import { mapState } from "vuex";

export default {
  name: "CategoriasMenu",
  directives: { ClosePopup },
  computed: {
    ...mapState(["canal"]),
    categories() {
      if (localStorage.canal == 9) {
        return this.canal.apps_categories;
      }
      return this.canal.categories;
    }
  },
  methods: {
    showCategory(categoryId, subCategory) {
      let path = `/${this.$route.params.slug}/listar`;
      let categoria = categoryId;
      if (subCategory == "sub") {
        this.$router.replace({ path, query: { categoria, componentes: this.$route.query.componentes } });
      } else if (subCategory.length == 0) {
        this.$router.replace({ path, query: { categoria, componentes: this.$route.query.componentes } });
      }
    }
  }
};
</script>
