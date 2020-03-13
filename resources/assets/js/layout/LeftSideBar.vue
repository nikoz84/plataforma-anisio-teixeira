<template>
  <nav>
    <q-list>
      <q-item-label v-if="!$q.screen.gt.xs || !$q.screen.gt.sm">
        <q-btn
          flat
          dense
          @click="leftDrawerOpenModel = false"
          aria-label="Menu"
          icon="dehaze"
        />
        <BtnMarca></BtnMarca>
      </q-item-label>
      <!-- ADMINISTRAÇÃO -->
      <q-item
        v-if="isLogged"
        clickable to="/admin/conteudos/listar"
      >
        <q-item-section avatar>
          <q-icon name="settings_applications" />
        </q-item-section>
        <q-item-section>
          <q-item-label>
            Admin
          </q-item-label>
        </q-item-section>
      </q-item>
      <q-separator v-if="isLogged" />
      <!-- HOME -->
      <q-item clickable to="/">
        <q-item-section avatar>
          <q-icon name="home" />
        </q-item-section>
        <q-item-section>
          <q-item-label>Início</q-item-label>
        </q-item-section>
      </q-item>
      <q-separator />
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
    </q-list>
    <!-- ADMINISTRAÇÃO-->
    <AdminLeftSideBar v-if="this.$route.name == 'admin'"></AdminLeftSideBar>
    <!-- CANAIS-->
    <q-list v-else>
      <q-item-label class="bg-grey-4" header>
        <div
          class="text-h6 text-primary"
          style="font-family: 'Concert One', sans-serif, cursive;"
        >
          CANAIS
        </div>
      </q-item-label>
      <div v-for="(link, i) in links" :key="`x-${i}`">
        <q-item
          tag="div"
          :to="`/${link.slug}/listar`"
          :aria-label="`endereço para: ${link.name}`"
          :title="`endereço para: ${link.name}`"
          clickable
          v-close-popup
          tabindex="0"
        >
          <q-item-section>
            <q-item-label>{{ link.name }}</q-item-label>
          </q-item-section>
        </q-item>
        <q-separator />
      </div>
      <q-item
        :to="`/praticas-pedagogicas`"
        aria-label="`endereço para: Práticas Pedagogicas`"
        :title="`endereço para: práticas pedagogicas`"
        clickable
        v-close-popup
        tabindex="0"
      >
        <q-item-section>
          <q-item-label>Práticas Pedagógicas</q-item-label>
        </q-item-section>
      </q-item>
    </q-list>
  </nav>
</template>
<script>
import { mapState } from "vuex";
import { QList, QItem, QItemSection, QIcon } from "quasar";
import BtnMarca from "./BtnMarca.vue";
import AdminLeftSideBar from "./AdminLeftSideBar.vue";

export default {
  name: "LeftSideBar",
  components: { BtnMarca, AdminLeftSideBar },
  props: ["leftDrawerOpen"],
  data() {
    return {
      admin: false,
      text: ""
    };
  },
  computed: {
    ...mapState(["isLogged", "links"]),
    leftDrawerOpenModel: {
      get() {
        return this.leftDrawerOpen;
      },
      set(val) {
        this.$emit("update:leftDrawerOpen", val);
      }
    }
  }
};
</script>
