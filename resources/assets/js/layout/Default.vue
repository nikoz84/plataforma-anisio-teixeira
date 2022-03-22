git status<template>
  <q-layout view="hHh lpR fff">
    <a
      class="skip-link"
      href="#main-content"
    >Pular ao conteúdo</a>
    <q-header
      dense
      class="glossy"
    >
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          @click="leftDrawerOpen = !leftDrawerOpen"
          aria-label="Menu"
          icon="menu"
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
            style="width: 260px"
            alt="Marca"
            square
            title="marca"
            aria-label="Marca da plataforma Anísio Teixeira"
          >
            <img
              alt="marca"
              src="/img/sprite/logo_colorido.png"
            >
          </q-avatar>
        </q-btn>

        <q-space />
        <AutocompleteForm></AutocompleteForm>
        <q-space />

        <div class="flex_modo_estudante">
          <span class="text-weight-bolder text-caption">ESTUDANTE</span>
          <div
            class="mode-toggle-student"
            @click="modeToggleStudent"
            :class="studentStudent"
          >
            <q-tooltip
              class="bg-petecaazul"
              :offset="[10, 10]"
            >
              Ativar modo do Estudante
            </q-tooltip>
            <div class="toggle-student">

              <div
                id="student-mode"
                type="checkbox"
              ></div>
            </div>
          </div>
        </div>

        <q-separator
          dark
          vertical
          inset
        />

        <div class="flex_modo_escuro">
          <span class="text-weight-bolder text-caption">MODO ESCURO</span>
          <div
            class="mode-toggle"
            @click="modeToggle"
            :class="darkDark"
          >
            <q-tooltip
              class="bg-indigo"
              :offset="[10, 10]"
            >
              Ativar modo escuro
            </q-tooltip>
            <div class="toggle">

              <div
                id="dark-mode"
                type="checkbox"
              ></div>
            </div>
          </div>
        </div>
        <q-separator
          dark
          vertical
          inset
        />

        <q-btn
          stretch
          flat
          label="Fale Conosco"
          to="/usuario/contato/faleconosco"
        />

        <q-separator
          dark
          vertical
          inset
        />
        <q-btn-dropdown
          stretch
          flat
          icon="person"
          dropdown-icon="arrow_drop_down"
          aria-label="Opçoes de usuário"
        >
          <q-list
            dense
            bordered
            padding
          >

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
      <div class="wave"></div>

    </q-header>

    <q-drawer
      show-if-above
      v-model="leftDrawerOpen"
      :mini="miniState"
      @mouseover="miniState = false"
      @mouseout="miniState = true"
      :width="350"
      :breakpoint="500"
      bordered
      class="bg-grey-3"
    >
      <LeftSideBar :leftDrawerOpen.sync="leftDrawerOpen"></LeftSideBar>

    </q-drawer>
    <q-footer elevated>

      <Footer></Footer>

    </q-footer>
    <q-page-container>
      <router-view
        id="main-content"
        name="main"
        style="min-height:800px"
      />
      <q-page-scroller position="bottom-right">
        <q-btn
          round
          color="accent"
          icon="arrow_upward"
          aria-label="subir ao topo"
        />
      </q-page-scroller>
    </q-page-container>
  </q-layout>
</template>
<script>
// @ts-nocheck

import { mapActions, mapState } from "vuex";
import { AutocompleteForm } from "@forms/search";
import LeftSideBar from "./LeftSideBar.vue";
import Footer from "./Footer.vue";

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
  GoBack,
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
    QSelect,
    Footer,
  },
  data() {
    return {
      leftDrawerOpen: this.openSideBar
        ? this.openSideBar
        : this.$q.platform.is.desktop,
      drawer: false,
      miniState: true,
      darkMode: false,
      studentMode: false,
    };
  },
  created() {
    this.getLayout();
  },
  computed: {
    ...mapState([
      "isLogged",
      "links",
      "canal",
      "sidebar",
      "layout",
      "openSideBar",
    ]),

    darkDark() {
      return this.darkMode && "darkmode-toggled";
    },
    studentStudent() {
      return this.studentMode && "studentmode-toggled";
    },
  },
  methods: {
    ...mapActions(["getLayout", "logout"]),
    async sair() {
      await this.logout();
      this.$router.push("/");
    },

    dark() {
      document.querySelector("body").classList.add("dark-mode");
      this.darkMode = true;
      this.$emit("dark");
    },

    light() {
      document.querySelector("body").classList.remove("dark-mode");
      document.querySelector("body").classList.remove("student-mode");
      this.darkMode = false;
      this.studentMode = false;
      this.$emit("light");
    },

    modeToggle() {
      if (
        this.darkMode ||
        document.querySelector("body").classList.contains("dark-mode")
      ) {
        this.light();
      } else {
        this.dark();
      }
    },

    student() {
      document.querySelector("body").classList.add("student-mode");
      this.studentMode = true;
      this.$emit("student");
    },

    modeToggleStudent() {
      if (
        this.studentMode ||
        document.querySelector("body").classList.contains("student-mode")
      ) {
        this.light();
      } else {
        this.student();
      }
    },
  },
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
