<template>
    <footer class="page-footer font-small" style="background-color: #2E2E2E;">
        <section style="background-color: #A4A4A4;">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-5">
                        <h6 class="mb-0"></h6>
                    </div>
                    <div class="col-md-6 col-lg-7 text-center text-md-right">
                        <a class="fb-ic"><i class="fa fa-facebook white-text mr-4"> </i></a>
                        <a class="gplus-ic"><i class="fa fa-google-plus white-text mr-4"> </i></a>
                        <a class="ins-ic"><i class="fa fa-instagram white-text"> </i></a>
                    </div>
                </div>
            </div>
        </section>
        <section class="container text-center text-md-left mt-5">
                <div class="row">
                <!-- Plataforma -->
                <div class="col-md-3 col-lg-4">
                    <h6 class="text-uppercase font-weight-bold" style="color:#FFFFFF">Plataforma Anísio Teixeira</h6>
                    <hr class="teal accent-3 " style="width: 60px;">
                    <p>Here you can use rows and columns here to organize your footer content. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                </div>
                <!-- Canais -->
                <div class="col-md-2 col-lg-2" style="color:#FFFFFF">
                    <h6 class="text-uppercase font-weight-bold">Canais</h6>
                    <hr class="teal accent-3 " style="width: 60px;">
                    <p><a href="/tv-anisio-teixeira/inicio">Tv Anísio Teixeira</a></p>
                    <p><a href="/emitec/inicio">Emitec</a></p>
                    <p><a href="/radio-anisio-teixeira/inicio">Radio Anísio Teixeira</a></p>
                </div>
                <!-- Secretária -->
                <div class="col-md-3 col-lg-2">
                    <h6 class="text-uppercase font-weight-bold" style="color:#FFFFFF">Secretaría da Educação</h6>
                    <hr class="teal accent-3 " style="width: 60px;">
                    <p><a class="dark-grey-text" href="http://escolas.educacao.ba.gov.br/">Escolas</a></p>
                    <p><a class="dark-grey-text" href="http://estudantes.educacao.ba.gov.br/">Estudantes</a></p>
                    <p><a class="dark-grey-text" href="http://educadores.educacao.ba.gov.br/">Educadores</a></p>
                    <p><a class="dark-grey-text" href="http://institucional.educacao.ba.gov.br/">Institucional</a></p>
                    <p><a class="dark-grey-text" href="http://municipios.educacao.ba.gov.br/">Municípios</a></p>
                </div>
                <!-- Contato -->
                <div class="col-md-4 col-lg-3">
                    <h6 class="text-uppercase font-weight-bold" style="color:#FFFFFF">Contato</h6>
                    <hr class="teal accent-3" style="width: 60px;">
                    <p><i class="fa fa-home mr-3"></i> Salvador, Bahia, Brasil</p>
                    <p><i class="fa fa-envelope mr-3"></i> info@example.com</p>
                    <p><i class="fa fa-phone mr-3"></i> +55 71 3115 9061</p>
                </div>
                <div class="col-md-12">
                    <img src="http://pat.educacao.ba.gov.br/assets/img/img-logomarca-rodape.png">
                </div>
            </div>
        </section>
        <!--  -->
        <section class="footer-copyleft text-center"><span class="copyleft">&copy;</span> {{ year }} CopyLeft:
            <a href="/"> Plataforma Anísio Teixeira</a>
        </section>
    </footer>
</template>

<script>
    export default {
        name : 'footer-app',
        mounted() {
            this.getYear();
        },
        data(){
            return {
                year: null
            }
        },
        methods:{
            getYear(){
                let date = new Date();
                this.year = date.getFullYear(); 
            }
        }    
    }
</script>
<style lang="scss" scoped>
.page-footer { margin-top: 5vh; }
.font-weight-bold { font-weight: bold; }
.mb-4, .my-4 { margin-bottom: 1.5rem!important;}
.footer-copyleft { margin-top: 5vh; background-color: #D8D8D8;}
.copyleft{
    display:inline-block;
    -moz-transform: rotate(180deg);
    -o-transform: rotate(180deg);
    -ms-transform: rotate(180deg);
    -webkit-transform: rotate(180deg);
    transform: rotate(180deg);
}
hr{
    margin-top: 1rem;
    margin-bottom: 1rem;
    border: 0;
    border-top: 1px solid #1e78c2;
}
p{
    color: #e6e6e6;
}
</style>
