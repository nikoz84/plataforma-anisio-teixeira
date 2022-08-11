<template>
  <q-btn-dropdown
    stretch
    dropdown-icon="arrow_drop_down"
    flat
    icon="account_tree"
    :label="canal.category_name"
    v-if="canal && categories && categories.length > 0"
  >
    <q-list dense>
      <q-item
        clickable
        dense
        v-for="category in categories"
        :key="category.id"
        v-close-popup="category.sub_categories.length == 0"
        @click="showCategory(category, false)"
      >
        <q-item-section
          ><b>{{ category.name }}</b></q-item-section
        >
        <q-item-section
          side
          v-if="category.sub_categories && category.sub_categories.length > 0"
        >
          <q-icon name="keyboard_arrow_right" />
        </q-item-section>
        <!--  Subcategorias -->
        <q-menu :offset="[-75, 5]" v-if="category.sub_categories">
          <q-list>
            <q-item
              v-for="subcategory in category.sub_categories"
              :key="subcategory.id"
              clickable
              dense
              v-close-popup
              @click="showCategory(subcategory, true)"
            >
              <q-item-section>
                <b>{{ subcategory.name }}</b>
              </q-item-section>
            </q-item>
          </q-list>
        </q-menu>
      </q-item>
    </q-list>
  </q-btn-dropdown>
</template>
<script>
// @ts-nocheck

import {
  QTab,
  QMenu,
  QList,
  QItem,
  QItemSection,
  ClosePopup,
  QIcon,
  QBtnDropdown,
} from "quasar";
import { mapState } from "vuex";
import { QueryString } from "@/mixins/QueryString";

export default {
  name: "CategoriasMenu",
  components: {
    QTab,
    QMenu,
    QList,
    QItem,
    QItemSection,
    ClosePopup,
    QIcon,
    QBtnDropdown,
  },
  mixins: [QueryString],
  directives: { ClosePopup },
  computed: {
    ...mapState(["canal"]),
    categories() {
      if (localStorage.canal == 9) {
        return this.canal.apps_categories;
      }
      return this.canal.categories;
    },
  },
  methods: {
    showCategory(category, isSubcategory) {
      let length = category.sub_categories
        ? category.sub_categories.length
        : null;

      if (category.parent_id && isSubcategory && length == null) {
        this.replaceURL("categoria", category.id);
      } else if (!category.parent_id && !isSubcategory && !length) {
        this.replaceURL("categoria", category.id);
      }
    },
  },
};
</script>
