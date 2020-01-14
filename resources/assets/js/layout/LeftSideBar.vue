<template>
  <div>
    <q-list>
        <!-- MARCA -->
        <q-item-label v-if="!$q.screen.gt.xs || !$q.screen.gt.sm">
          <q-btn
            flat
            dense
            round
            @click="leftDrawerOpenModel = false"
            aria-label="Menu"
            icon="dehaze"
          />
          <q-btn flat no-caps no-wrap class="q-ml-xs" to="/" aria-label="voltar ao inicio">
            <img src="/logo.svg" alt="marca" aria-label="marca da plataforma Anísio Teixeira"/>
            <div clas="text-h6">
              PLATAFORMA ANÍSIO TEIXEIRA
            </div>
          </q-btn>
        </q-item-label>
        
        <q-separator />
        <q-item-label  header>
          <div class="text-h6 text-primary" style="font-family: 'Concert One', sans-serif, cursive;">CANAIS</div>
        </q-item-label>
        <!-- CANAIS -->
        <div v-for="(link, i) in links" :key="`x.${i}`">
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
      </q-list>

    <q-list>
        <q-item-label class="bg-grey-4" header>
          <b class="text-h5 text-grey-10"></b>
        </q-item-label>
        <!-- ADMINISTRAÇÃO -->
        <q-item
          v-if="isLogged"
          :to="`/admin/conteudos/listar`"
          clickable
          v-close-popup
          tabindex="0"
        >
          <q-item-section avatar>
            <q-icon name="settings_applications" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Administração</q-item-label>
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
  </div>
</template>
<script>
import { mapState } from "vuex";
import { QList, QItem, QItemSection, QIcon } from "quasar";

export default {
  name: "LeftSideBar",
  props: ["leftDrawerOpen"],
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
