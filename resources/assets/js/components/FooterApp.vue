<template>
    <footer class="page-footer mt-4" style="background-color: #082250;">
        <section class="container-fluid" style="background-color: #082250;">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-5">
                        <h6 class="mb-0">Redes Sociais</h6>
                    </div>
                    <div class="col-md-6 col-lg-7 text-center">
                        <a class="fb-ic"><i class="fa fa-facebook white-text"> </i></a>
                    </div>
                </div>
            </div>
        </section>
        <section class="container-fluid" style="background-color: #08275E;">
            <section class="container text-center">
                <div class="row mt-4">
                 <!-- Secretária -->
                <div class="col-md-12 mb-4" v-if="layout.secretaria">
                        <h6 class="text-uppercase font-weight-bold">Secretaría da Educação</h6>
                        <hr style="width: 80px;">
                        <ul class="list-inline">
                            <li v-for="(item, i) in layout.secretaria" :key="i" class="li-sec" :style="{'background-color':item.color}">
                                <a class="a-sec" :href="item.url" target="_blank">
                                    {{item.title}}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
        </section>
        <section class="container-fluid" style="background-color: #172b4e;">
            <section class="container text-center mt-4">
                <!-- Contato -->
                <div class="col-md-3 col-lg-3 mb-4" v-if="layout.contact">
                    <h6 class="text-uppercase font-weight-bold">Contato</h6>
                    <hr style="width: 80px;">
                    <p><i class="glyphicon glyphicon-home mr-3"></i> {{ layout.contact.city }}</p>
                    <p><i class="glyphicon glyphicon-envelope mr-3"></i> {{ layout.contact.email }}</p>
                    <p><i class="glyphicon glyphicon-phone-alt mr-3"></i> {{ layout.contact.phone }}</p>
                    <router-link tag="p" :to="{ name: 'FaleConoscoForm', path: 'faleconosco'}">
                          Ou <a style="color: #1e78c2;"> Fale Conosco</a>
                    </router-link>
                </div>
                <!-- Plataforma -->
                <div class="col-md-9 col-lg-9 mb-4" v-if="layout.description_footer">
                    <h6 class="text-uppercase font-weight-bold">Plataforma Anísio Teixeira</h6>
                    <hr style="width: 80px;">
                    <p v-text="layout.description_footer"></p>
                </div>
                <!-- Canais -->
                <div class="col-md-12 mt-4 mb-4" v-if="links">
                    <h6 class="text-uppercase font-weight-bold">Canais</h6>
                    <hr style="width: 80px;">
                    <ul class="list-inline">
                        <router-link v-for="(link,i) in links" 
                                :key="i" 
                                tag="li" 
                                :to="{ name: 'Listar', params: {slug: link.slug}}">
                            <a style="color: #fff;">{{link.name}}</a> |
                        </router-link>
                    </ul>
                </div>
            </section>
        </section>
        <!--  -->
        <section class="footer-copyleft">
            <div class="container">
                <div class="footer-cc row">
                    <div class="col-lg-2">
                        <a href="https://creativecommons.org/">
                          <img class="image-cc" src="/img/creative-commons.svg" target="_blank">
                        </a>
                    </div>
                    <div class="col-lg-10">
                        <p class="p-cc">
                            <a href="/"> Plataforma Anísio Teixeira</a>    
                            <span class="copyleft">&copy;</span> {{ year }} | 
                            Todos os direitos e conteúdos desta Plataforma são 
                            de uso compartilhado, exceto onde indicado de outra forma.
                            Site desenvolvido em  
                            <a href="https://laravel.com/" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 84.1 57.6"><path fill="#FB503B" d="M83.8 26.9c-.6-.6-8.3-10.3-9.6-11.9-1.4-1.6-2-1.3-2.9-1.2s-10.6 1.8-11.7 1.9c-1.1.2-1.8.6-1.1 1.6.6.9 7 9.9 8.4 12l-25.5 6.1L21.2 1.5c-.8-1.2-1-1.6-2.8-1.5C16.6.1 2.5 1.3 1.5 1.3c-1 .1-2.1.5-1.1 2.9S17.4 41 17.8 42c.4 1 1.6 2.6 4.3 2 2.8-.7 12.4-3.2 17.7-4.6 2.8 5 8.4 15.2 9.5 16.7 1.4 2 2.4 1.6 4.5 1 1.7-.5 26.2-9.3 27.3-9.8 1.1-.5 1.8-.8 1-1.9-.6-.8-7-9.5-10.4-14 2.3-.6 10.6-2.8 11.5-3.1 1-.3 1.2-.8.6-1.4zm-46.3 9.5c-.3.1-14.6 3.5-15.3 3.7-.8.2-.8.1-.8-.2-.2-.3-17-35.1-17.3-35.5-.2-.4-.2-.8 0-.8S17.6 2.4 18 2.4c.5 0 .4.1.6.4 0 0 18.7 32.3 19 32.8.4.5.2.7-.1.8zm40.2 7.5c.2.4.5.6-.3.8-.7.3-24.1 8.2-24.6 8.4-.5.2-.8.3-1.4-.6s-8.2-14-8.2-14L68.1 32c.6-.2.8-.3 1.2.3.4.7 8.2 11.3 8.4 11.6zm1.6-17.6c-.6.1-9.7 2.4-9.7 2.4l-7.5-10.2c-.2-.3-.4-.6.1-.7.5-.1 9-1.6 9.4-1.7.4-.1.7-.2 1.2.5.5.6 6.9 8.8 7.2 9.1.3.3-.1.5-.7.6z"></path></svg>
                            Laravel
                            </a>
                             e 
                            <a href="https://vuejs.org/" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 196.32 170.02"><path fill="#42b883" d="M120.83 0L98.16 39.26 75.49 0H0l98.16 170.02L196.32 0h-75.49z"/><path fill="#35495e" d="M120.83 0L98.16 39.26 75.49 0H39.26l58.9 102.01L157.06 0h-36.23z"/></svg>
                            Vuejs
                            </a>.
                        </p> 
                    </div>
                </div>
            </div>
        </section>
    </footer>
</template>

<script>
import { mapState } from "vuex";

export default {
  name: "FooterApp",
  mounted() {
    this.getYear();
  },
  data() {
    return {
      year: null
    };
  },
  computed: {
    ...mapState(["links", "layout"])
  },
  methods: {
    getYear() {
      let date = new Date();
      this.year = date.getFullYear();
    }
  }
};
</script>
<style lang="scss" scoped>
.page-footer {
  margin-top: 5vh;
}
.font-weight-bold {
  font-weight: bold;
  color: #ffffff;
}
.footer-cc {
  margin-top: 50px;
  margin-bottom: 50px;
}

.p-cc {
  color: #0d2626;
}
.mt-4 {
  margin-top: 40px;
}
.mb-4 {
  margin-bottom: 40px;
}
.footer-copyleft {
  margin-top: 5vh;
  background-color: #d8d8d8;
}
.copyleft {
  display: inline-block;
  -moz-transform: rotate(180deg);
  -o-transform: rotate(180deg);
  -ms-transform: rotate(180deg);
  -webkit-transform: rotate(180deg);
  transform: rotate(180deg);
}
hr {
  margin-top: 1rem;
  margin-bottom: 1rem;
  border: 0;
  border-top: 1px solid #1e78c2;
}
p {
  color: #e6e6e6;
}
.li-sec {
  padding: 15px;
  margin: 5px;
}
.li-sec:hover {
  opacity: 0.7;
}
.a-sec {
  color: #e6e6e6;
  text-decoration: none;
}
</style>
