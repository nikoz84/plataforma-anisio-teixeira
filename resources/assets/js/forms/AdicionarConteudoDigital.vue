<template>
    <div class="conteiner">

        <form>

            <div class="form-group">
                <label for="titulo">Título:*</label>
                <input type="text" class="form-control" id="titulo" aria-describedby="titulo">
                <small id="titulo" class="form-text text-muted">Adicione o nome original da mídia.</small>
            </div>

            <div class="form-group">
            <label for="estado">Tipo de Conteúdo:*</label>
            <select class="form-control form-control-lg" id="licenca-relacionada">
                <option value="">« SELECIONE »</option>
                <option value="7">Animação/Simulação</option>
                <option value="3">Apresentação</option>
                <option value="4">Áudio</option>
                <option value="1">Documento/Experimento</option>
                <option value="6">Imagem</option>
                <option value="2">Planilha</option>
                <option value="10">Sequência Didática</option>
                <option value="8">Site</option>
                <option value="9">Software Educacional</option>
                <option value="5">Vídeo</option>
            </select>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição:*</label>
                <textarea class="form-control" id="descricao"></textarea>
            </div>

            <div class="form-group">
                <label for="palavra-chave">Palavras-Chave:*</label>
                <input type="text" class="form-control" id="palavra-chave">
            </div>

            <div class="form-group">
                <label for="icone-licenca">Icone da Licença:*</label>
                <input type="file" class="form-control" id="icone-licenca" aria-describedby="icone-licenca">
                <small id="icone-licenca" class="form-text text-muted">Imagem no formato .png, dimensão: 200px x 90px, tamanho máximo: 600KB</small>
            </div>

            <div class="form-group">
                <button class="btn btn-default">Enviar</button>
            </div>

        </form>

    </div>
</template>