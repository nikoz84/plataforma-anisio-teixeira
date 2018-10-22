<template>
    <div class="conteiner">

        <form>

            <div class="form-group">
                <label for="nome">Nome:*</label>
                <input type="text" class="form-control" id="nome" placeholder="Digite seu nome">
            </div>

            <div class="form-group">
                <label for="email">E-mail:*</label>
                <input type="email" class="form-control" id="email" placeholder="Digite seu e-mail">
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
                <label for="assunto">Assunto:*</label>
                <input type="text" class="form-control" id="assunto" placeholder="Qual é o assunto do contato">
            </div>

            <div class="form-group">
                <label for="assunto">URL:</label>
                <input type="text" class="form-control" id="url" value="http://pat.educacao.ba.gov.br/">
            </div>

            <div class="form-group">
                <button class="btn btn-default">Enviar</button>
            </div>

        </form>

    </div>
</template>