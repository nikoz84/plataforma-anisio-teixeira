<template>
  <section class="container-fluid heigth">
    <section class="main" id="main-home">
      <!--article v-for="(destaque, i) in plataforma" :key="'i'+i">
            <div :class="(destaque.is_principal) ? 'col-md-5 destaque-principal': 'col-md-3 destaque-secundario'">
                <img v-lazy="destaque.img" class="img-responsive">
                <div class="retina">
                <div class="texto">
                        <ul>
                            <li>
                                <h1>
                                    {{ destaque.name }}
                                </h1>
                            </li>
                            <li>
                                <p>
                                    {{ destaque.description }}
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </article-->

        <!--article v-for="(menu, i) in menu" :key="'i'+i">
            <div>

            </div>
        </article-->
      <div class="row">
        <h2>Conteúdos Destacados</h2>
        <article class="col-sm-3 no-padding" v-for="(conteudo, d) in data.conteudos_destaque" :key="`${d}d`">
            <div class="">
                <img  v-lazy="conteudo.image" class="img-responsive">
            </div>
            <div>
                <h3>{{ conteudo.title }}</h3>
                
                <p><a class="btn btn-primary" href="#" role="button">Saiba mais »</a></p>
            </div>
        </article>
      </div>
      <div class="row">
        <h2>Conteúdos mais Recentes</h2>
        <article class="col-sm-3 no-padding" v-for="(conteudo, c) in data.conteudos_recentes" :key="`${c}c`">
            <div class="">
                <img  v-lazy="conteudo.image" class="img-responsive">
            </div>
            <div>
                <h3>{{ conteudo.title }}</h3>
                
                <p><a class="btn btn-primary" href="#" role="button">Saiba mais »</a></p>
            </div>
        </article>
      </div>
      <div class="row">
        <h2>Conteúdos mais Baixados</h2>
        <article class="col-sm-3 no-padding" v-for="(conteudo, b) in data.conteudos_baixados" :key="`${b}b`">
            <div class="">
                <img  v-lazy="conteudo.image" class="img-responsive">
            </div>
            <div>
                <h3>{{ conteudo.title }}</h3>
                <p><a class="btn btn-primary" href="#" role="button">Saiba mais »</a></p>
            </div>
        </article>
      </div>
      
      <div class="row">
        <h2>Conteúdos mais Acessados</h2>
        <article class="col-sm-3 no-padding" v-for="(conteudo, a) in data.conteudos_acessados" :key="`${a}a`">
            <div class="">
                <img  v-lazy="conteudo.image" class="img-responsive">
            </div>
            <div>
                <h3>{{ conteudo.title }}</h3>
                
                <p><a class="btn btn-primary" href="#" role="button">Saiba mais »</a></p>
            </div>
        </article>
      </div>
      <div class="row">
        <h2>Aplicativos Destacados</h2>
        <article class="col-sm-3 no-padding" v-for="(aplicativo, a) in data.aplicativos_destaque" :key="'a'+a">
            <div class="">
                <img  v-lazy="aplicativo.image" class="img-responsive">
            </div>
            <div>
                <h3>{{ aplicativo.name }}</h3>
                <p><a class="btn btn-primary" href="#" role="button">Saiba mais »</a></p>
            </div>
        </article>
      </div>
    </section>
  </section>
</template>
<script>
import { mapState, mapMutations } from "vuex";

export default {
  name: "Home",
  data() {
    return {
      data: {}
    };
  },
  mounted() {
    this.getData();
  },
  methods: {
    async getData() {
      let resp = await axios.get("/destaques");
      console.log(resp);
      this.data = resp.data;
    }
  }
};
</script>
<style lang="scss" scoped>
.texto h1 {
  color: #ffffff;
  font-size: 30px;
  font-weight: bold;
  font-family: "Lucida Sans", "Lucida Sans Regular", "Lucida Grande",
    "Lucida Sans Unicode", Geneva, Verdana, sans-serif;
}
.texto p {
  color: #ffffff;
  font-size: 15px;
  text-align: justify;
  margin: 10px;
  font-family: "Lucida Sans", "Lucida Sans Regular", "Lucida Grande",
    "Lucida Sans Unicode", Geneva, Verdana, sans-serif;
}
.texto ul {
  margin: 5px;
}

/* Style page content - use this if you want to push the page content to the right when you open the side navigation */
#main-home {
  transition: margin-left 0.5s;
  padding: 20px;
  min-height: 90vh;
}
.box-shadow {
  -webkit-box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
  box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
}
.no-padding {
  padding: 0;
}
.container-fluid .btn-flutuante {
  position: fixed;
  left: 1rem;
  top: 1rem;
}

/* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
@media screen and (max-height: 450px) {
  .sidebar {
    padding-top: 15px;
  }
  .sidebar a {
    font-size: 18px;
  }
}
</style>