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
      <AdminLeftSideBar></AdminLeftSideBar>
    </q-drawer>

    <q-page-container>
      <router-view  name="main"/>
      <q-page-scroller position="bottom-right">
        <q-btn round color="accent" icon="arrow_upward" aria-label="subir ao topo"/>
      </q-page-scroller>
    </q-page-container>
  </q-layout>
</template>
<script>
// @ts-nocheck
import { mapActions, mapState } from "vuex";
import AdminLeftSideBar from "./AdminLeftSideBar.vue";
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
  name: "Admin",
  directives: { GoBack },
  components: {
    AdminLeftSideBar,
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
      leftDrawerOpen: this.$q.platform.is.desktop
    }
  },
  created() {
      const vlibras  = window.document.getElementById('vlibras');
      vlibras.classList.remove('enabled');
      vlibras.classList.add('disabled');
  },
  computed: {
    ...mapState(["isLogged"])
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
