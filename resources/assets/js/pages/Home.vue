<template>
  <section class="q-pa-md">
    <!-- BOTÕES CAROUSEL 
    <CarouselHome></CarouselHome>-->

    <CarouselHomeEstudantes></CarouselHomeEstudantes>

    <!-- PRÁTICAS INSPIRADORAS 

    <a class="skip-link" href="#praticas-inspiradoras">Ir a práticas inspiradoras</a>
    <PlayListHome id="praticas-inspiradoras"></PlayListHome>
    -->

    <section :class="`imagem_full_home-${randomNumber}`">

      <div class="texto_full_home">
        <div>Texto de boas vindas ou vídeo</div>
      </div>

    </section>

    <div
      class="row justify-center q-py-lg q-gutter-lg"
      style="margin-top: -48px;"
    >
      <!-- TIPOS DE CONTEUDO
      <a
        class="skip-link"
        href="#tipo-conteudos"
      >Ir a tipos de conteúdos</a>
      <CardHomeIcon
        id="tipo-conteudos"
        title="Tipos de Conteúdos"
        :items="tipos"
        v-if="tipos"
      ></CardHomeIcon>

       ENSINO MEDIO 
      <a
        class="skip-link"
        href="#ensino-medio"
      >Ir a disciplinas do ensino medio</a>
      <CardHomeIcon
        id="ensino-medio"
        v-if="disciplinas"
        :title="disciplinas.name"
        :items="disciplinas.componentes"
      ></CardHomeIcon>

       TEMAS TRANSVERSAIS 
      <a
        class="skip-link"
        href="#temas-transversais"
      >Ir a temas transversais</a>
      <CardHomeIcon
        id="temas-transversais"
        v-if="temas"
        :title="temas.name"
        :items="temas.componentes"
      ></CardHomeIcon>-->
    </div>
    <!-- BOTÕES ROTINAS DE ESTUDO -->
    <a
      class="skip-link"
      href="#rotinas-de-estudo"
    >Ir a rotinas de estudo</a>
    <HomeLinksRotinas id="rotinas-de-estudo"></HomeLinksRotinas>

    <ConteudosPaginaInicial></ConteudosPaginaInicial>

    <a
      class="skip-link"
      href="#conteudos-recentes"
    >Ir a adicionados recentemente</a>
    <CardHome id="conteudos-recentes"></CardHome>

    <MenuAvancadoHome></MenuAvancadoHome>

    <!-- SESSÃO ADICINADOS RECENTEMENTE 

    <a
      class="skip-link"
      href="#conteudos-recentes"
    >Ir a adicionados recentemente</a>
    <CardHome id="conteudos-recentes"></CardHome>-->
  </section>
</template>
<script>
// @ts-nocheck

import { mapState } from "vuex";
import {
  CarouselHome,
  CardHome,
  CardHomeIcon,
  HomeLinksRotinas,
  PlayListHome,
  CarouselHomeEstudantes,
  ConteudosPaginaInicial,
  MenuAvancadoHome,
} from "@components/home";
import {
  QParallax,
  ScrollFire,
  QBanner,
  QCard,
  QCardSection,
  QCardActions,
  QBtn,
  QAvatar,
  QBtnGroup,
} from "quasar";

export default {
  name: "Home",
  directives: {
    ScrollFire,
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
    PlayListHome,
    CarouselHomeEstudantes,
    ConteudosPaginaInicial,
    MenuAvancadoHome,
  },
  data() {
    return {
      randomNumber: "",
    };
  },
  methods: {
    getRandomIntInclusive(min, max) {
      min = Math.ceil(min);
      max = Math.floor(max);
      this.randomNumber = Math.floor(Math.random() * (max - min + 1)) + min; //The maximum is inclusive and the minimum is inclusive
    },
  },
  created() {
    this.getRandomIntInclusive(0, 8);
  },
  computed: {
    ...mapState(["tipos", "componentes", "niveis"]),
    disciplinas() {
      if (this.niveis.length) {
        let niveis = this.niveis.filter((nivel) => {
          if (nivel.id === 5) return nivel;
        });
        return niveis[0];
      }
    },
    temas() {
      if (this.componentes.length) {
        let componentes = this.componentes.filter((componente) => {
          if (componente.id === 3) return componente;
        });
        return componentes[0];
      }
    },
  },
};
</script>

