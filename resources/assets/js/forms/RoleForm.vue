<template>
    <div class="conteiner">
        <form>
            <!-- NOME -->
            <div class="form-group">
                <label for="nomelicenca">Função do usuário:*</label>
                <input type="text" class="form-control" id="nomelicenca">
            </div>
            

            <div class="form-group">
                <button class="btn btn-default">Enviar</button>
            </div>

        </form>

    </div>
</template>
<script>
export default {
  name: "RoleForm"
};
</script>