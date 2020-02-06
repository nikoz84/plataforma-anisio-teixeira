<template>
    <div>
        <q-tab :label="categoryName" v-if="categoryName">
          <q-menu anchor="bottom middle" self="top middle">
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

                <q-menu anchor="center middle" self="center middle" v-if="hasSubCategories(category)">
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
          </q-menu>
        </q-tab>
    </div>
</template>
<script>
import { QTab, QMenu, QList, QItem, QItemSection, ClosePopup } from "quasar";
export default {
  name: "CategoriasMenu",
  data (){
    return {
       categoryName: "",
       categories: []
    }
  },
  directives: { ClosePopup },
  methods: {
    showCategory(categoryId, subCategory) {
      let path = `/${this.$route.params.slug}/listar`;
      let categoria = categoryId;
      if (subCategory == "sub") {
        this.$router.push({ path, query: { categoria } });
      } else if (subCategory.length == 0) {
        this.$router.push({ path, query: { categoria } });
      }
    }
  }
};
</script>
