<template>
    <q-btn-dropdown auto-close stretch dropdown-icon="arrow_drop_down" :icon="icone(canal.filters.id)" flat :label="label(canal.filters.id)" v-if="show">
        <q-list >
            <q-item clickable v-close-popup
                v-for="(filter, i) in canal.filters.componentes" 
                :key="i"
                @click="replaceURL('componentes', filter.id)"
                >
                <q-item-section avatar v-if="filter.icon">
                    <q-avatar left square>
                      <img lazyload :src="filter.icon"/>
                    </q-avatar>
                </q-item-section>
                <q-item-section>{{filter.name}}</q-item-section>
            </q-item>
        </q-list>
    </q-btn-dropdown>
</template>
<script>
import { QTab, QMenu, QList, QItem, QItemSection, ClosePopup } from "quasar";
import { mapState } from "vuex";
import { QueryString } from '@mixins/QueryString';

export default {
  name: "Filters",
  mixins: [QueryString],
  computed: {
    ...mapState(["canal"]),
    show() {
      return this.canal && this.canal.filters && this.canal.filters.componentes;
    }
  },
  methods: {
    label(id) {
      switch (id) {
        case 3:
          return "Temas Transversais";
          break;
        case 5:
          return "Disciplinas";
        default:
          break;
      }
    },
    icone(id) {
      switch (id) {
        case 3:
          return "transform";
          break;
        case 5:
          return "school";
        default:
          break;
      }
    }
  }
};
</script>

