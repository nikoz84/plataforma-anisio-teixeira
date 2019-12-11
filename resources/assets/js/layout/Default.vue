<template>
  <q-layout view="hHh lpR fFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn flat dense round @click="leftDrawerOpen = !leftDrawerOpen" aria-label="Menu" icon="dehaze"/>
        <q-btn flat no-caps no-wrap class="q-ml-xs" to="/" v-if="$q.screen.gt.sm">
          <q-icon name="img:/logo.svg" />
          
          <q-toolbar-title shrink >
            Plataforma Anísio Teixeira
          </q-toolbar-title>
        </q-btn>

        <q-space/>
        
        <div class="toolbar-input-container row no-wrap">
          <q-input dense outlined square v-model="search" placeholder="Pesquiçar" class="bg-white col" />
          <q-btn class="toolbar-input-btn" color="grey-3" text-color="grey-8" icon="search" unelevated />
        </div>
        
        <q-space/>

        <q-btn-dropdown stretch flat icon="person">
          <q-list>
            <q-item v-if="!isLogged" to="/usuario/login" clickable v-close-popup tabindex="0">
              <q-item-section>
                <q-item-label>Login</q-item-label>
              </q-item-section>
            </q-item>
            <q-item v-if="isLogged" to="/usuario/recuperar-senha" clickable v-close-popup tabindex="0">
              <q-item-section>
                <q-item-label>Alterar senha</q-item-label>
              </q-item-section>
            </q-item>
            <q-item v-if="isLogged" @click="sair()" clickable v-close-popup tabindex="0">
              <q-item-section>
                <q-item-label>Sair</q-item-label>
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
        <!-- MARCA -->
        <q-item-label v-if="!$q.screen.gt.xs || !$q.screen.gt.sm">
          <q-btn flat dense round @click="leftDrawerOpen = !leftDrawerOpen" aria-label="Menu" icon="dehaze"/>
          <q-btn flat no-caps no-wrap class="q-ml-xs" to="/">
            <q-icon name="img:/logo.svg" />
            <div clas="text-h6">
              PLATAFORMA ANÍSIO TEIXEIRA
            </div>
          </q-btn>
        </q-item-label>
        <!-- HOME -->
        <q-item clickable to="/">
          <q-item-section avatar>
            <q-icon name="home" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Início</q-item-label>
          </q-item-section>
        </q-item>
        <q-separator/>
        <q-item-label class="bg-grey-3" header >
          <b>CANAIS</b>
        </q-item-label>
        <!-- CANAIS -->
        <div v-for="(link, i) in links" :key="`x.${i}`">
          <q-item tag="div" :to="`/${link.slug}/listar`" clickable v-close-popup tabindex="0">
            <q-item-section>
              <q-item-label>{{ link.name }}</q-item-label>
            </q-item-section>
          </q-item>
          <q-separator/>
        </div>
      </q-list>
      
      <q-list>
        <q-item-label class="bg-grey-4" header >
          <b class="text-h5 text-grey-10"></b>
        </q-item-label>
        <!-- ADMINISTRAÇÃO -->
        <q-item v-if="isLogged" :to="`/admin/conteudos/listar`" clickable v-close-popup tabindex="0">
          <q-item-section avatar>
            <q-icon name="settings_applications" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Administração</q-item-label>
          </q-item-section>
        </q-item>
        <q-separator v-if="isLogged" />
        <!-- SOBRE -->
        <q-item clickable to="/sobre">
          <q-item-section avatar>
            <q-icon name="info" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Sobre</q-item-label>
          </q-item-section>
        </q-item>
        <q-separator />
        <!-- GALERIA -->
        <q-item clickable to="/galeria">
          <q-item-section avatar>
            <q-icon name="photo" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Galeria</q-item-label>
          </q-item-section>
        </q-item>
        <q-separator />
        <!-- Fale conosco -->
        <q-item clickable to="/usuario/contato/faleconosco" >
          <q-item-section avatar>
            <q-icon name="message" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Fale Conosco</q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
      
      
    </q-drawer>

    <q-page-container>
      <router-view />
       <q-page-scroller position="bottom-right">
        <q-btn round color="dark" icon="arrow_upward" />
      </q-page-scroller>
    </q-page-container>
  </q-layout>
</template>
<script>
import { mapActions, mapState } from "vuex";

import {
  QLayout,
  QDrawer,
  QHeader,
  QToolbar,
  QSpace,
  QSeparator,
  QToolbarTitle,
  QPageContainer,
  QPageScroller,
  QList,
  QItemLabel,
  QItem,
  QItemSection,
  QExpansionItem,
  QSelect,
  GoBack,
  Platform
} from "quasar";

export default {
  name: "Default",
  directives: { GoBack },
  componentes: {
    QLayout,
    QDrawer,
    QHeader,
    QSpace,
    QSeparator,
    QToolbar,
    QToolbarTitle,
    QPageContainer,
    QPageScroller,
    QList,
    QItem,
    QItemSection,
    QItemLabel,
    QExpansionItem,
    QSelect
  },
  data() {
    return {
      leftDrawerOpen: this.$q.platform.is.desktop,
      search: ""
    };
  },
  created() {
    this.getLayout();
  },
  computed: {
    ...mapState(["isLogged", "links", "canal", "sidebar", "layout"])
  },
  methods: {
    ...mapActions(["getLayout", "logout"]),
    sair() {
      this.logout().then(() => {
        if (!this.isLogged) {
          this.$router.push("/");
        }
      });
    }
  }
};
</script>
<style lang="stylus">
.drawer-footer-link {
  color: inherit;
  text-decoration: none;
  font-weight: 500;
  font-size: 0.75rem;

  &:hover {
    color: #000;
  }
}

.toolbar-input-container {
  min-width: 100px;
  width: 50%;
}

.toolbar-input-btn {
  border-radius: 0;
  border-style: solid;
  border-width: 1px 1px 1px 0;
  border-color: rgba(0, 0, 0, 0.24);
  max-width: 60px;
  width: 100%;
}
</style>