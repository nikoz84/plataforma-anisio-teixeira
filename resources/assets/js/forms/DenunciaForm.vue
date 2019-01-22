<!--<script src='https://www.google.com/recaptcha/api.js?render=6Ld8LIoUAAAAAGYhAY9niFaoUehmASAHvH04eo20'></script>-->
<template>
    <div class="conteiner">

        <form>
            <p>Este espaço serve para você denunciar qualquer coisa que você considere imprópria,
               basta fornecer o endereço da página onde esse conteúdo se localiza e uma mensagem 
               descrevendo do que se trata e por que você acha que essa página merece a denuncia.

            </p>

            <div class="form-group">
                <label for="nome">Nome:*</label>
                <input type="text" class="form-control" id="nome" placeholder="Digite seu nome">
            </div>

            <div class="form-group">
                <label for="email">E-mail:*</label>
                <input type="email" class="form-control" id="email" placeholder="Digite seu e-mail">
            </div>

            <div class="form-group">
                <label for="assunto">URL:</label>
                <input type="text" class="form-control" id="url" value="http://pat.educacao.ba.gov.br/">
            </div>

            <div class="form-group">
                <label for="assunto">Assunto:*</label>
                <input type="text" class="form-control" id="assunto" placeholder="Qual é o assunto do contato">
            </div>

            <div class="form-group">
                <label for="mensagem">Mensagem:*</label>
                <textarea class="form-control" id="mensagem" placeholder="Digite aqui sua mensagem"></textarea>
            </div>

            <div class="form-group">
                <label for="mensagem">Código de segurança:*</label>
                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                       <!-- <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_SITE_KEY') }}"></div>
                        @if ($errors->has('g-recaptcha-response'))
                            <span class="invalid-feedback" style="display: block;">
                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                            </span>
                        @endif0-->
                    </div>
                </div>

            </div>

            <div class="form-group">
                <button class="btn btn-default">Enviar</button>
            </div>

        </form>

    </div>
</template>