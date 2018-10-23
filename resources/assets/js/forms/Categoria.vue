<template>
    <div class="conteiner">

        <form>

            <div class="form-group">
                <label for="titulo">Titulo:*</label>
                <input type="text" class="form-control" id="titulo">
            </div>

            <div class="form-group">
                <label for="desc-categoria">Descrição categoria:*</label>
                <textarea id="desc-categoria" name="desc-categoria" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="canal">Canal:</label>
                <select class="form-control form-control-lg" id="canal" aria-describedby="canal">
                    <option value="">« SELECIONE UM CANAL »</option>
                </select>
                <small id="canal" class="form-text text-muted">Selecione uma categoria se precisar agrupar por sub-categorias</small>               
            </div>

            <div class="form-group">
                <label for="categoria-relacionada">Categoria relacionada:*</label>
                <input type="text" class="form-control" id="categoria-relacionada">
            </div>

            <div class="form-group">
                <label for="ativo">Ativo:*</label>
                <input type="checkbox" class="form-control" id="ativo">
            </div>

            <div class="form-group">
                <label for="fldestaque">Destacado:*</label>
                <input type="checkbox" class="form-control" id="fldestaque">
            </div>

            <div class="form-group">
                <label for="icone-categoria">Icone da categoria:*</label>
                <input type="file" class="form-control" id="icone-categoria" aria-describedby="icone-categoria">
                <small id="icone-categoria" class="form-text text-muted">Imagem no formato .png, jpg, dimensão: 400px x 220px, tamanho máximo: 2MB</small>               
            </div>

            <div class="form-group">
                <label for="video-destaque">Vídeo destaque:</label>
                <input type="file" class="form-control" id="video-destaque" aria-describedby="video-destaque">
                <small id="video-destaque" class="form-text text-muted">Vídeo no formato .webm, tamanho máximo: 50MB</small>               
            </div>

            <div class="form-group">
                <button class="btn btn-default">Enviar</button>
            </div>

        </form>

    </div>
</template>