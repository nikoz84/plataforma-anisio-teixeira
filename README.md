# PLATAFORMA ANÍSIO TEIXEIRA

O Ambiente Educacional Web – AEW é um projeto de aprendizagem (Baseado em Laravel 5.5) voltado ao compartilhamento de conteúdos digitais através de licenças livres, disponibilizado na internet no endereço (http://pat.educacao.ba.gov.br) para acesso e utilização de todos; constituído pelos seguintes módulos:

Você poderá criar canais dinámicos, conteúdos digitais, aplicativos educacionais, sites temáticos.

## SOFTWARE LIVRE

Estamos liberando o código da aplicação para cumprir com o propósito para o qual foi criado o Ambiente Educacional Web, ser um software livre, para que qualquer pessoa ou também outras secretarias de educação no Brasil sejam parte deste projeto aberto para a comunidade de desenvolvimento, por isso o convidamos a instalar o aplicativo em seu servidor local.

## COMO ESTA IMPLEMENTADO

Criamos uma API RESTFUL que se comunica com frontend feito em VUE.js permitindo desacoplar as camadas de frontend do backend:

- Backend - PHP 7+
- Backend - Laravel Framework 5.5+
- Backend - Servidor Apache 2.2
- Backend - Banco de dados Postgres 9.5+
- Frontend - VUE JS, BOOTSTRAP, SASS

## COMO INSTALAR

Faça uma copia do arquivo .env.example, e renomee a copia para .env, em este arquivo você vai adicionar as configurações do banco de dados o outras configurações. Além disso, você precisará criar um chave de verificação da aplicação na variavel global chamada APP_KEY. Pode criar esta chave com o comando que criará uma chave em base 64. E também criar a secret key para a autenticação com Json Web Token.

``$ php artisan key:generate; php artisan jwt:secret``

Instalar as dependencias do laravel com composer:

``$ composer install``

Se tiver problemas com a instalação das dependencias verifique as extensões de PHP

``sudo apt install php7.*-tokenizer php7.*-dom php7.*-mbstring``


Instalar as dependências do Vuejs com npm:

``$ npm install``

Nota: Se tiver algum problema com instalar o modulo node-sass pode forçar a instalação com:

``$ npm i node-sass --unsafe-perm=true``

Crie o esquema do banco de dados no Postgresql com o comando:

``$ php arstisan migrate``

Agora podemos arrancar o servidor embutido do framework:

``$ php artisan serve``

## CONTRIBUTORS
Nicolás Romero

<a href="https://github.com/nikoz84"><img src="https://avatars1.githubusercontent.com/u/6708508?s=460&v=4" title="Nicolás Romero" width="80" height="80"></a>


Fabiano Muniz

<a href="https://github.com/fabianomuniz"><img src="https://avatars1.githubusercontent.com/u/22965696?s=460&v=4" title="Fabiano Muniz" width="80" height="80"></a>
