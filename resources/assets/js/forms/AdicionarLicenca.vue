<template>
    <div class="conteiner">

        <form>

            <div class="form-group">
                <label for="nomelicenca">Nome da Licença:*</label>
                <input type="text" class="form-control" id="nomelicenca">
            </div>

            <div class="form-group">
            <label for="estado">Licença relacionada:</label>
            <select class="form-control form-control-lg" id="licenca-relacionada">
                <option value="">« SELECIONE »</option>
            </select>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição:*</label>
                <textarea class="form-control" id="descricao"></textarea>
            </div>

            <div class="form-group">
                <label for="site-referenciado">Site referenciado:</label>
                <input type="text" class="form-control" id="site-referenciado">
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