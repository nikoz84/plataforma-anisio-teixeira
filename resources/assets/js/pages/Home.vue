<template>
    <div class="container-fluid heigth">
        <aside class="sidebar" id="sidebar-home">
            <a class="closebtn" @click.prevent="closeSidebar()">&times;</a>

            <div class="input-group" style="padding-top:60px;">
                <input type="text" class="form-control" placeholder="Busca...">
                <span class="input-group-btn">
                    <button class="btn btn-default glyphicon glyphicon-search" type="button" ></button>
                </span>
            </div>
            <h4 class="text-center">Mais Recentes</h4>
            <ul>
                <li v-for="(recente, r) in recentes" :key="'r'+r">
                    <a class="link" href="#">{{ recente.name }}</a>
                </li>
            </ul>

            <h4 class="text-center">Palavras Chave</h4>
            <ul class="list-inline">
                <li v-for="(tag, t) in tags" :key="'t'+t">
                    <a class="badge" href="#" > {{ tag.name }}</a>
                </li>
            </ul>
        </aside>

        <section class="main" id="main-home">
            <article v-for="(listagem, m) in menu" :key="'m'+m">
                <div class="col-md-3">
                    <ul>
                        <li>
                            {{ menu.name }}
                        </li>
                    </ul>
                </div>
            </article>

            <article v-for="(destaque, i) in plataforma" :key="'i'+i">
                <div :class="(destaque.is_principal) ? 'col-md-5 destaque-principal': 'col-md-3 destaque-secundario'">
                    <img :src="destaque.img">
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
            </article>

            <article v-for="(aplicativo, a) in aplicativos" :key="'a'+a">
                <div class="">
                    <img :src="aplicativo.img">
                </div>
                <div class="">
                    <h2>{{ aplicativo.name }}</h2>
                    <p>{{ aplicativo.description }}</p>
                    <p><a class="btn btn-primary" href="#" role="button">Saiba mais »</a></p>
                </div>
            </article>
            <article>
                {{this.$store.state.layout}}
            </article>
        </section>
        <div class="btn-flutuante">
            <span @click="openSidebar()" class="btn btn-default afix" data-spy="affix" data-offset-bottom="50%">Pesquisar</span>
        </div>
    </div>
</template>
<script>
export default {
  name: "Home",
  data() {
    return {
        aplicativos: [
            {
                name: 'Mozilla Firefox',
                description: 'O Firefox é um navegador web livre desenvolvido pela Mozilla Foundation. A intenção da fundação foi desenvolver um navegador leve, seguro, intuitivo e altamente extensível. Baseado...',
                img: 'http://pat.educacao.ba.gov.br/conteudos/aplicativos-educacionais/imagem-associada/110.jpg'
            },
            {
                name: 'LibreOffice',
                description: 'Suite (conjunto de programas) mais utilizada em escritórios, mas que pode ser adaptada ao contexto educativo. Vem com o Writer (Editor de Texto), Calc (Planilha), Impress (apresentação)...',
                img: 'http://pat.educacao.ba.gov.br/conteudos/aplicativos-educacionais/imagem-associada/17.jpg'
            },
            {
                name: 'Linux Educacional 6.0',
                description: 'O ProInfo é um projeto que visa promover o uso pedagógico de tecnologias da informação relacionadas a conteúdos educacionais nas escolas públicas de todo o Brasil. Nesse contexto...',
                img: 'http://pat.educacao.ba.gov.br/conteudos/aplicativos-educacionais/imagem-associada/33.jpg'
            },
            {
                name: 'GIMP',
                description: 'O Firefox é um navegador web livre desenvolvido pela Mozilla Foundation. A intenção da fundação foi desenvolver um navegador leve, seguro, intuitivo e altamente extensível. Baseado...',
                img: 'http://pat.educacao.ba.gov.br/conteudos/aplicativos-educacionais/imagem-associada/110.jpg'
            }
        ],
        plataforma:[
            {
                name: 'EMITEC',
                description: 'Com as aulas do Ensino Médio com Intermediação Tecnológica (Emitec), você terá acesso aos conteúdos prioritários do Ensino Médio. Aqui você pode pesquisar as aulas por disciplina, ano de ensino e unidade, além de poder visualizar, de forma fácil, os vídeos mais recentes, mais vistos e os mais baixados.',
                img: 'http://pat.educacao.ba.gov.br/assets/img/slider/banner-emitec.jpg',
                is_principal: true
            },
            {
                name: 'Aplicativos Educacionais',
                description: 'Softwares livres, aplicativos móveis e ambientes digitais de apoio a produção e a colaboração nos processos de ensino e de aprendizagem.',
                img: 'http://colaborativus.pat.educacao.ba.gov.br/pluginfile.php/68435/course/overviewfiles/destaque-home-plataforma.jpg',
                is_principal: false
            },
            {
                name: 'AVT Polos UAB - Bahia',
                description: 'Espaço destinado ao propósito de manter a interação e a comunicação das atividades diárias dos Polos UAB e seu trabalho.',
                img: 'http://colaborativus.pat.educacao.ba.gov.br/pluginfile.php/46944/course/overviewfiles/destaque-home-plataforma.jpg',
                is_principal: false
            }

        ],
        recentes:[
            {name: 'Fica a Dica Enem - Como Tirar Nota 1.000 na Redação?'},
            {name: 'O Que Mais Cai em Filosofia e Sociologia no ENEM? Plantão'},
            {name: 'Fica a Dica Enem - Como Tirar Nota 1.000 na Redação?'}
        ],
        tags:[
            {name: 'biologia'},
            {name: 'conceito digital'},
            {name: 'matemática'},
            {name: 'preconceito racial'}
        ],
        menu:[
            {name: 'TV Anísio Teixeira'},
            {name: 'Rádio Anísio Teixeira'},
            {name: 'Emitec'},
            {name: 'Projetos Artísticos'},
            {name: 'Sites Temáticos'}
        ]
    };
  },
  methods:{
    openSidebar(){
        document.getElementById("sidebar-home").style.width = "50%";
    },
    closeSidebar(){
        document.getElementById("sidebar-home").style.width = "0";
    }
  }
};
</script>
<style lang="scss" scoped>

.sidebar {
  height: 100%; /* 100% Full-height */
  width: 0; /* 0 width - change this with JavaScript */
  position: fixed; /* Stay in place */
  z-index: 1500; /* Stay on top */
  top: 0;
  left: 0;
  background-color: #ffffff; /* Black*/
  overflow-x: hidden; /* Disable horizontal scroll */
  padding-top: 60px; /* Place content 60px from the top */
  transition: 0.5s; /* 0.5 second transition effect to slide in the sidenav */
}

.sidebar a.link {
  //padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 16px;
  color: #1c7eb7;
  display: block;
  transition: 0.3s;
}

.sidebar a:hover {
  color: #0e9298;
}

/* Position and style the close button (top right corner) */
.sidebar .closebtn {
  position: absolute;
  bottom: 150px;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
  text-decoration: none;
}
.texto h1{
    color: #ffffff;
    font-size: 30px;
    font-weight: bold;
    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
}
.texto p{
    color: #ffffff;
    font-size: 15px;
    text-align: justify;
    margin: 10px;
    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
}
.texto ul{
    margin: 5px;
}


.affix {
    bottom: 100px;
    right: 20px;
    z-index: 9999 !important;
}
/* Style page content - use this if you want to push the page content to the right when you open the side navigation */
#main-home {
  transition: margin-left .5s;
  padding: 20px;
}

.container-fluid .btn-flutuante{
   position: fixed;
    left: 1rem;
    top: 1rem;
}

/* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
@media screen and (max-height: 450px) {
  .sidebar {padding-top: 15px;}
  .sidebar a {font-size: 18px;}
}

</style>