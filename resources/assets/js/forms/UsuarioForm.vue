<template>
    <div class="conteiner">

        <form>

            <div class="form-group">
                <label for="login">Login:*</label>
                <input type="email" class="form-control" id="login" aria-describedby="login_usuario" placeholder="Digite o login de usuário">
                <small id="login_usuario" class="form-text text-muted">Pode utilizar uma conta de e-mail como login (exemplo: aew.usuario@gmail.com, aew.usuario@hotmail.com)</small>               
            </div>

            <div class="form-group">
                <label for="nome">Nome:*</label>
                <input type="text" class="form-control" id="nome" placeholder="Digite o completo do usuário">
            </div>

            <div class="form-group">
                <label for="tipo_usuario">Tipo usuário:*</label>
                <select class="form-control" id="tipo_usuario">
                <option value="0"> SELECIONE </option>
                <option value="1">super administrador</option>
                <option value="2">administrador</option>
                <option value="3">coordenador</option>
                <option value="4">editor</option>
                <option value="5">colaborador</option>
                </select>
            </div>

            <div class="form-check">
                <input class="form-check-input" name="usuarioperfilcanal[]" type="checkbox" value="" id="usuarioperfilcanal1">
                <label class="form-check-label" for="usuarioperfilcanal1">
                    Ambiente de Ensino a Aprendizagem Colaborativa
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="usuarioperfilcanal[]" type="checkbox" value="" id="usuarioperfilcanal2">
                <label class="form-check-label" for="usuarioperfilcanal2">
                    Aplicativos Educacionais
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="usuarioperfilcanal[]" type="checkbox" value="" id="usuarioperfilcanal3">
                <label class="form-check-label" for="usuarioperfilcanal3">
                    Blog da Rede
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="usuarioperfilcanal[]" type="checkbox" value="" id="usuarioperfilcanal4">
                <label class="form-check-label" for="usuarioperfilcanal4">
                    EMITEC - Ensino Médio com Intermediação Tecnológica
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="usuarioperfilcanal[]" type="checkbox" value="" id="usuarioperfilcanal5">
                <label class="form-check-label" for="usuarioperfilcanal5">
                    Mídias Educacionais
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="usuarioperfilcanal[]" type="checkbox" value="" id="usuarioperfilcanal6">
                <label class="form-check-label" for="usuarioperfilcanal6">
                    Projetos Artísticos
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="usuarioperfilcanal[]" type="checkbox" value="" id="usuarioperfilcanal7">
                <label class="form-check-label" for="usuarioperfilcanal7">
                    Rádio Anísio Teixeira
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="usuarioperfilcanal[]" type="checkbox" value="" id="usuarioperfilcanal8">
                <label class="form-check-label" for="usuarioperfilcanal8">
                    Sites Temáticos
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="usuarioperfilcanal[]" type="checkbox" value="" id="usuarioperfilcanal9">
                <label class="form-check-label" for="usuarioperfilcanal9">
                    Tv Anísio Teixeira
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label" for="sexo">
                    Sexo:
                </label>
                <input class="form-check-input" type="radio" name="sexo" id="sexo-m" value="m" checked>
                <input class="form-check-input" type="radio" name="sexo" id="sexo-f" value="f" checked>
            </div>
            <div class="form-group">
                <label for="datanascimento">Data de nascimento:</label>
                <input type="date" class="form-control" id="datanascimento" name="datanascimento">
            </div>
            <div class="form-group">
                <label for="emailinstitucional">E-mail Institucional:*</label>
                <input type="email" class="form-control" id="emailinstitucional" name="emailinstitucional">
            </div>
            <div class="form-group">
                <label for="emailpessoal">E-mail Pessoal:*</label>
                <input type="email" class="form-control" id="emailpessoal" name="emailpessoal">
            </div>
            <div class="form-group">
                <label for="emailpessoal">E-mail Pessoal:*</label>
                <input type="email" class="form-control" id="emailpessoal" name="emailpessoal">
            </div>
            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" class="form-control" id="cpf" name="cpf">
            </div>
            <div class="form-group">
                <label for="cpf">RG:</label>
                <input type="text" class="form-control" id="rg" name="rg">
            </div>
            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="text" class="form-control" id="telefone" name="telefone">
            </div>
            <div class="form-group">
                <label for="endereco">Endereço:</label>
                <input type="text" class="form-control" id="endereco" name="endereco">
            </div>
            <div class="form-group">
                <label for="numero">Número:</label>
                <input type="text" class="form-control" id="numero" name="numero">
            </div>
            <div class="form-group">
                <label for="complemento">complemento:</label>
                <input type="text" class="form-control" id="complemento" name="complemento ">
            </div>
            <div class="form-group">
            <label for="estado">Estado:</label>
            <select class="form-control form-control-lg" id="estado">
                <option value="">« SELECIONE »</option>
                <option value="2">Não Informado</option>
                <option value="2116">BA</option>
                <option value="2573">AC</option>
                <option value="2574">AL</option>
                <option value="2575">AP</option>
                <option value="2576">AM</option>
                <option value="2577">CE</option>
                <option value="2578">DF</option>
                <option value="2579">ES</option>
                <option value="2580">GO</option>
                <option value="2581">MA</option>
                <option value="2582">MT</option>
                <option value="2583">MS</option>
                <option value="2584">MG</option>
                <option value="2585">PA</option>
                <option value="2586">PB</option>
                <option value="2587">PR</option>
                <option value="2588">PE</option>
                <option value="2589">PI</option>
                <option value="2590">RJ</option>
                <option value="2591">RN</option>
                <option value="2592">RS</option>
                <option value="2593">RO</option>
                <option value="2594">RR</option>
                <option value="2595">SC</option>
                <option value="2596">SP</option>
                <option value="2597">SE</option>
                <option value="2598">TO</option>
            </select>
            </div>
            <div class="form-group">
                <label for="municipio">Município:</label>
                <select class="form-control form-control-lg" id="municipio">
                    <option value="">« SELECIONE »</option>
                </select>
            </div>
            <div class="form-group">
                <label for="bairro">Bairro:</label>
                <input type="text" class="form-control" id="bairro" name="bairro">
            </div>
            <div class="form-group">
                <label for="cep">CEP:</label>
                <input type="text" class="form-control" id="cep" name="cep">
            </div>
            <div class="form-group">
                <label for="escola">Escola:</label>
                <select class="form-control form-control-lg" id="escola">
                    <option value="">« SELECIONE »</option>
                </select>
            </div>




        </form>

    </div>
</template>