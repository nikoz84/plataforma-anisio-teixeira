<template>
  <section class="q-pa-md">
    <!-- BOTÕES CAROUSEL -->
    <CarouselHome></CarouselHome>

    <!-- PRÁTICAS INSPIRADORAS-->
    <a class="skip-link" href="#praticas-inspiradoras">Ir a práticas inspiradoras</a>
    <PlayListHome id="praticas-inspiradoras"></PlayListHome>
    
    <!-- BOTÕES ROTINAS DE ESTUDO -->
    <a class="skip-link" href="#rotinas-de-estudo">Ir a rotinas de estudo</a>
    <HomeLinksRotinas id="rotinas-de-estudo"></HomeLinksRotinas>

    <!-- SESSÃO ADICINADOS RECENTEMENTE -->
    
    <a class="skip-link" href="#conteudos-recentes">Ir a adicionados recentemente</a>
    <CardHome id="conteudos-recentes"></CardHome>
    
    <!-- TIPOS DE CONTEUDO -->
    <a class="skip-link" href="#tipo-conteudos">Ir a tipos de conteúdos</a>
    <CardHomeIcon
      id="tipo-conteudos"
      title="Tipos de Conteúdos"
      :items="tipos"
      v-if="tipos"
    ></CardHomeIcon>
    
    <!-- ENSINO MEDIO -->
    <a class="skip-link" href="#ensino-medio">Ir a disciplinas do ensino medio</a>
    <CardHomeIcon
      id="ensino-medio"
       v-if="disciplinas"
      :title="disciplinas.name"
      :items="disciplinas.componentes"
    ></CardHomeIcon>
    
    <!-- TEMAS TRANSVERSAIS -->
    <a class="skip-link" href="#temas-transversais">Ir a temas transversais</a>
    <CardHomeIcon
      id="temas-transversais"
      v-if="temas"
      :title="temas.name"
      :items="temas.componentes"
    ></CardHomeIcon>
  </section>
</template>
<script>// @ts-nocheck

import { mapState } from "vuex";
import { CarouselHome, CardHome, CardHomeIcon, HomeLinksRotinas, PlayListHome } from "@components/home";
import {
  QParallax,
  ScrollFire,
  QBanner,
  QCard,
  QCardSection,
  QCardActions,
  QBtn,
  QAvatar,
  QBtnGroup
} from "quasar";

export default {
  name: "Home",
  directives: {
    ScrollFire
  },
  components: {
    QBanner,
    QCard,
    QCardSection,
    QCardActions,
    QBtn,
    QAvatar,
    CardHomeIcon,
    QBtnGroup,
    CarouselHome,
    HomeLinksRotinas,
    CardHome,
    PlayListHome
  },
  computed: {
    ...mapState(["tipos", "componentes", "niveis"]),
    disciplinas() {
      if (this.niveis.length) {
        let niveis = this.niveis.filter(nivel => {
          if (nivel.id === 5) return nivel;
        });
        return niveis[0];
      }
    },
    temas() {
      if (this.componentes.length) {
        let componentes = this.componentes.filter(componente => {
          if (componente.id === 3) return componente;
        });
        return componentes[0];
      }
    }
  }
};
</script>

