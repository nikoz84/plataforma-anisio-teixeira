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
                    <a href="#">Fale conosco</a>
                    <p><i class="fa fa-home mr-3"></i> Salvador, Bahia, Brasil</p>
                    <p><i class="fa fa-envelope mr-3"></i> info@example.com</p>
                    <p><i class="fa fa-phone mr-3"></i> +55 71 3115 9061</p>
                </div>
                <div class="col-md-12">
                    <img class="img-responsive" src="http://pat.educacao.ba.gov.br/assets/img/img-logomarca-rodape.png"> <i class="fa fa-envelope-square"></i>
                </div>
            </div>
        </section>
        <!--  -->
        <section class="footer-copyleft">
            <div class="container">
                <div class="row">
                    <div class="col-3 col-md-2">
                        <img src="http://pat.educacao.ba.gov.br/assets/img/creative_commons.png">
                    </div>
                    <div class="col-3 col-md-4">
                        <span class="copyleft">&copy;</span> {{ year }} | Todos os direitos e conteúdos desta Plataforma são de uso compartilhado, exceto onde indicado de outra forma. O site foi desenvolvido em <a href="https://laravel.com/"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 84.1 57.6"><path fill="#FB503B" d="M83.8 26.9c-.6-.6-8.3-10.3-9.6-11.9-1.4-1.6-2-1.3-2.9-1.2s-10.6 1.8-11.7 1.9c-1.1.2-1.8.6-1.1 1.6.6.9 7 9.9 8.4 12l-25.5 6.1L21.2 1.5c-.8-1.2-1-1.6-2.8-1.5C16.6.1 2.5 1.3 1.5 1.3c-1 .1-2.1.5-1.1 2.9S17.4 41 17.8 42c.4 1 1.6 2.6 4.3 2 2.8-.7 12.4-3.2 17.7-4.6 2.8 5 8.4 15.2 9.5 16.7 1.4 2 2.4 1.6 4.5 1 1.7-.5 26.2-9.3 27.3-9.8 1.1-.5 1.8-.8 1-1.9-.6-.8-7-9.5-10.4-14 2.3-.6 10.6-2.8 11.5-3.1 1-.3 1.2-.8.6-1.4zm-46.3 9.5c-.3.1-14.6 3.5-15.3 3.7-.8.2-.8.1-.8-.2-.2-.3-17-35.1-17.3-35.5-.2-.4-.2-.8 0-.8S17.6 2.4 18 2.4c.5 0 .4.1.6.4 0 0 18.7 32.3 19 32.8.4.5.2.7-.1.8zm40.2 7.5c.2.4.5.6-.3.8-.7.3-24.1 8.2-24.6 8.4-.5.2-.8.3-1.4-.6s-8.2-14-8.2-14L68.1 32c.6-.2.8-.3 1.2.3.4.7 8.2 11.3 8.4 11.6zm1.6-17.6c-.6.1-9.7 2.4-9.7 2.4l-7.5-10.2c-.2-.3-.4-.6.1-.7.5-.1 9-1.6 9.4-1.7.4-.1.7-.2 1.2.5.5.6 6.9 8.8 7.2 9.1.3.3-.1.5-.7.6z"></path></svg><span> Laravel</span></a>
                    </div>
                    <a href="/"> Plataforma Anísio Teixeira</a>
                </div>
            </div>
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
