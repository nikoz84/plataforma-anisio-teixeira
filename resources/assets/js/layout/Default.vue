<template>
  <q-layout view="hHh lpR fFf">
    <a class="skip-link" href="#main-content">Pular ao conteúdo</a>
    <q-header elevated dense>
      <q-toolbar >
        <q-btn
          flat
          dense
          round
          @click="leftDrawerOpen = !leftDrawerOpen"
          aria-label="Menu"
          icon="dehaze"
        />
        <q-btn
          flat
          class="q-ml-xs"
          aria-label="voltar ao inicio"
          to="/"
          v-if="$q.screen.gt.xs"
          size="sm"
        >
          <q-avatar
            style="width: 200px;height: 44px;"
            alt="Marca"
            square
            title="marca"
            aria-label="Marca da plataforma Anísio Teixeira">
              <img alt="marca" src="/img/sprite/logo.svg">
          </q-avatar>
        </q-btn>

        <q-space />
        <AutocompleteForm></AutocompleteForm>
        <q-space />

        <q-btn-dropdown stretch flat icon="person" dropdown-icon="arrow_drop_down" aria-label="Opçoes de usuário">
          <q-list>
            <q-item clickable to="/usuario/contato/faleconosco" aria-label="fale conosco">
              <q-item-section>
                <q-item-label>Fale Conosco</q-item-label>
              </q-item-section>
            </q-item>
            <q-item
              v-if="!isLogged"
              to="/usuario/login"
              clickable
              v-close-popup
              tabindex="0"
            >
              <q-item-section>
                <q-item-label>Login</q-item-label>
              </q-item-section>
            </q-item>

            <q-item
              v-if="isLogged"
              to="/usuario/mudar-senha"
              clickable
              v-close-popup
              tabindex="0"
            >
              <q-item-section>
                <q-item-label>Alterar senha</q-item-label>
              </q-item-section>
            </q-item>
            <q-item
              v-if="isLogged"
              @click="sair()"
              clickable
              v-close-popup
              tabindex="0"
            >
              <q-item-section>
                <q-item-label>Sair</q-item-label>
              </q-item-section>
            </q-item>
          </q-list>
        </q-btn-dropdown>
      </q-toolbar>
    </q-header>

    <q-drawer v-model="leftDrawerOpen" bordered content-class="bg-grey-2">
      <LeftSideBar :leftDrawerOpen.sync="leftDrawerOpen"></LeftSideBar>
    </q-drawer>

    <q-page-container>
      <router-view id="main-content" name="main"/>
      <q-page-scroller position="bottom-right">
        <q-btn round color="accent" icon="arrow_upward" aria-label="subir ao topo"/>
      </q-page-scroller>
    </q-page-container>
  </q-layout>
</template>
<script>// @ts-nocheck

import { mapActions, mapState } from "vuex";
import { AutocompleteForm } from "@forms/search";
import LeftSideBar from "./LeftSideBar.vue";
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
  QMenu,
  QSelect,
  GoBack
} from "quasar";

export default {
  name: "Default",
  directives: { GoBack },
  components: {
    AutocompleteForm,
    LeftSideBar,
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
      leftDrawerOpen: this.openSideBar ? this.openSideBar : this.$q.platform.is.desktop
    };
  },
  created() {
    this.getLayout();
  },
  computed: {
    ...mapState(["isLogged", "links", "canal", "sidebar", "layout", "openSideBar"])
  },
  methods: {
    ...mapActions(["getLayout", "logout"]),
    async sair() {
      await this.logout();
      this.$router.push('/');
    }
  }
};
</script>
<style lang="stylus">
.skip-link {
  position: absolute;
  top: -40px;
  left: 0;
  background: #000000;
  color: white;
  padding: 8px;
  z-index: 100;
}

.skip-link:focus {
  top: 0;
}

.drawer-footer-link {
  color: inherit;
  text-decoration: none;
  font-weight: 500;
  font-size: 0.75rem;

  &:hover {
    color: #000;
  }
}
</style>
