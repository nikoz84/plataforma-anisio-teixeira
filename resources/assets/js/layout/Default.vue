<template>
  <q-layout view="hHh lpR fFf">
    <q-header elevated>
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
          no-caps
          no-wrap
          class="q-ml-xs"
          to="/"
          v-if="$q.screen.gt.sm"
        >
          <q-icon name="img:/logo.svg" />

          <q-toolbar-title shrink>
            Plataforma Anísio Teixeira
          </q-toolbar-title>
        </q-btn>

        <q-space />

        
        <AutocompleteForm></AutocompleteForm>
        

        <q-space />

        <q-btn-dropdown stretch flat icon="person">
          <q-list>
            <!-- Fale conosco -->
            <q-item clickable to="/usuario/contato/faleconosco">
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
              to="/usuario/recuperar-senha"
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
      <LeftSideBar :leftDrawerOpen="leftDrawerOpen"></LeftSideBar>
    </q-drawer>

    <q-page-container>
      <router-view />
      <q-page-scroller position="bottom-right">
        <q-btn round color="accent" icon="arrow_upward" />
      </q-page-scroller>
    </q-page-container>
  </q-layout>
</template>
<script>
import { mapActions, mapState } from "vuex";
import AutocompleteForm from "../forms/AutocompleteForm.vue";
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
      leftDrawerOpen: this.$q.platform.is.desktop
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
</style>
