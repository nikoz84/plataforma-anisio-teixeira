<template>
    <section class="container-fluid heigth">
        <div class="row">
            <div class="col-lg-2">
                <!--<div class="input-group">
                    <input type="text" class="form-control" placeholder="Busca...">
                    <span class="input-group-btn">
                        <button class="btn btn-default glyphicon glyphicon-search" type="button" ></button>
                    </span>
                </div>-->

                <!-- lista Tags -->
                <nav>
                <ul class="nav nav-pills nav-stacked">
                    <li role="presentation" class="active"><a href="#">CANAIS</a></li>
                    <li role="presentation"><a href="#">TV Anísio Teixeira</a></li>
                    <li role="presentation"><a href="#">Rádio Anísio Teixeira</a></li>
                    <li role="presentation"><a href="#">Emitec</a></li>
                    <li role="presentation"><a href="#">Projetos Artísticos</a></li>
                    <li role="presentation"><a href="#">Sites Temáticos</a></li>
                    <li role="presentation"><a href="#">Outros</a></li>
                    <li role="presentation"><a href="#">Outros</a></li>
                    <li role="presentation"><a href="#">Outros</a></li>
                    <li role="presentation"><a href="#">Outros</a></li>
                    <li role="presentation"><a href="#">Outros</a></li>
                    <li role="presentation"><a href="#">Outros</a></li>
                    <li role="presentation"><a href="#">Outros</a></li>
                </ul>
                </nav>

            </div>

            <div class="col-md-5 destaque">

                    <img src="http://pat.educacao.ba.gov.br/assets/img/slider/banner-emitec.jpg">
                    <div class="retina">
                        <div class="texto">
                            <ul>
                                <li><h1>Centros Juvenis de Ciência e Cultura</h1></li>
                                <li><p>Projeto que trabalha com ensino complementar e oferece atividades interdisciplinares em que alunos têm acesso a conhecimentos científicos, cursos e oficinas.</p></li>
                            </ul>
                        </div>
                    </div>

            </div>


            <a href="#"><div class="col-md-3 destaque2">
                <img src="http://colaborativus.pat.educacao.ba.gov.br/pluginfile.php/68435/course/overviewfiles/destaque-home-plataforma.jpg">
                <!--<div class="retina">
                    <div class="texto">
                        <ul>
                            <li><h1>Aplicativos Educacionais</h1></li>
                            <li><p>Softwares livres, aplicativos móveis e ambientes digitais de apoio a produção e a colaboração nos processos de ensino e de aprendizagem.</p></p></li>
                        </ul>
                    </div>
                </div>-->
            </div></a>

            <a href="#"><div class="col-md-3 destaque2">
                <img src="http://colaborativus.pat.educacao.ba.gov.br/pluginfile.php/46944/course/overviewfiles/destaque-home-plataforma.jpg">
                <!--<div class="retina">
                    <div class="texto">
                        <ul>
                            <li><h1>AVT Polos UAB - Bahia</h1></li>
                            <li><p>Espaço destinado ao propósito de manter a interação e a comunicação das atividades diárias dos Polos UAB e seu trabalho.</p></p></li>
                        </ul>
                    </div>
                </div>-->
            </div></a>

            <div class="col-md-9">
                    <form class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search">
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
            </div>

                    

        </div>

    </section>

</template>
<script>
export default {
  name: "Home",
  data() {
    return {};
  }
};
</script>
<style lang="sass" scoped>

</style>