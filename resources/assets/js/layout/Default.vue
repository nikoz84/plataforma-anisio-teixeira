<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          @click="leftDrawerOpen = !leftDrawerOpen"
          aria-label="Menu"
          icon="menu"
        />
        <q-toolbar-title>
          Plataforma Anísio Teixeira
        </q-toolbar-title>

        <q-space/>

        <q-btn-dropdown stretch flat label="Canais">
          <q-list>
            <q-item :to="`/${link.slug}`" v-for="(link, i) in links" :key="`x.${i}`" clickable v-close-popup tabindex="0">
              <q-item-section>
                <q-item-label>{{ link.name }}</q-item-label>
              </q-item-section>
            </q-item>
          </q-list>
        </q-btn-dropdown>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      bordered
      content-class="bg-grey-2"
    >
      <q-list>
        <q-input standout="bg-grey-11" v-model="termSearch" label="Pesquisar" :dense="false">
          <template v-slot:prepend>
            <q-icon class="text-primary" name="search" />
          </template>
        </q-input>
        
        <q-item clickable tag="a" to="/">
          <q-item-section avatar>
            <q-icon name="home" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Inicio</q-item-label>
          </q-item-section>
        </q-item>
       
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
       <q-page-scroller position="bottom">
        <q-btn fab icon="keyboard_arrow_up" color="red" />
      </q-page-scroller>
    </q-page-container>
  </q-layout>
</template>
<script>
import { mapActions, mapState } from "vuex";
import SidebarCanal from "../components/SidebarCanal.vue";
import {
  QLayout,
  QDrawer,
  QHeader,
  QToolbar,
  QSpace,
  QToolbarTitle,
  QPageContainer,
  QPageScroller,
  QList,
  QItemLabel,
  QItem,
  QItemSection,
  QInput
} from "quasar";

export default {
  name: "Default",
  componentes: {
    QLayout,
    QDrawer,
    QHeader,
    QSpace,
    QToolbar,
    QToolbarTitle,
    QPageContainer,
    QPageScroller,
    QList,
    QItemLabel,
    QItem,
    QItemSection,
    QInput,
    SidebarCanal
  },
  data() {
    return {
      leftDrawerOpen: this.$q.platform.is.desktop,
      termSearch: ""
    };
  },
  created(){
    this.getLayout();
  },
  computed:{
    ...mapState(["links"])
  },
  methods:{
    ...mapActions(["getLayout"])
  }
};
</script>
<style >
</style>