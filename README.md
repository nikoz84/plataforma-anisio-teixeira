# PLATAFORMA ANÍSIO TEIXEIRA

O Ambiente Educacional Web – AEW é um projeto de aprendizagem (Baseado em Laravel 5.8) voltado ao compartilhamento de conteúdos digitais através de licenças livres, disponibilizado na internet no endereço (http://pat.educacao.ba.gov.br) para acesso e utilização de todos.

Você poderá criar canais dinámicos, conteúdos digitais, aplicativos educacionais, sites temáticos.

## SOFTWARE LIVRE

Estamos liberando o código da aplicação para cumprir com o propósito para o qual foi criado o Ambiente Educacional Web, ser um software livre, para que qualquer pessoa ou também outras secretarias de educação no Brasil sejam parte deste projeto aberto para a comunidade de desenvolvimento, por isso o convidamos a instalar o aplicativo em seu servidor local.

## COMO ESTA IMPLEMENTADO

Criamos uma API RESTFUL que se comunica com frontend feito em VUE.js permitindo desacoplar as camadas de frontend do backend:

- Backend - PHP 7.1+
- Backend - Laravel Framework 5.8+
- Backend - Servidor Apache 2.2
- Backend - Banco de dados Postgres 9.5+
- Frontend - VUE JS 2.6, Quasar Framework 1.9+

## COMO INSTALAR

Faça uma copia do arquivo .env.example, e renomee para .env, em este arquivo você vai adicionar as seguintes configurações:

- Banco de dados
- APP_KEY: variavel global de verificação da aplicação em base 64: `$ php artisan key:generate;`
- JWT_SECRET: chave para a autenticação com Json Web Token: `$ php artisan jwt:secret;`
- Também será adicionado um link simbólico da pasta public na pasta storage/app/public: `$ php artisan storage:link`
- Para editar os componentes do Laravel mail que criará uma pasta em /resources/views/vendor/mail `php artisan vendor:publish --tag=laravel-mail`
- Lembre dar as permissões para o usuário apache para a pasta storage, em UBUNTU seria:

`$ sudo chgrp -R www-data storage bootstrap/cache`
`$ sudo chmod -R ug+rwx storage bootstrap/cache`

Instalar as dependências do laravel com composer:

`$ composer install`

Se tiver problemas com a instalação das dependencias verifique as extensões de PHP

`$ sudo apt install php7.*-tokenizer php7.*-dom php7.*-mbstring`

Instalar as dependências do Vuejs com npm, lembre ter instalado o NODEJS:

`$ npm install`


### crlf

> Nota: Se trabalhar com windows ou linux o git pode ter uma incosistência para converter como terminam as linhas de um arquivo de texto, para evitar esse comportamento adicione nas configurações gerais do git `$ git config core.autocrlf true`

Crie o esquema do banco de dados no Postgresql com o comando:

`$ php arstisan migrate`

Agora podemos arrancar o servidor embutido do framework:

`$ php artisan serve`

[Versões](https://github.com/nikoz84/plataforma-anisio-teixeira/blob/master/TAGS.md)

## CONTRIBUTORS

Nicolás Romero

<a href="https://github.com/nikoz84"><img src="https://avatars1.githubusercontent.com/u/6708508?s=460&v=4" title="Nicolás Romero" width="80" height="80"></a>



Paulo Vitor Carvalho Santos

<a href="https://github.com/Paulo25"><img src="https://avatars2.githubusercontent.com/u/29576745?s=400&u=e8e26e84e3703941505e735b25cf3cf97a4c60c4&v=4" title="Paulo Vitor Carvalho Santos" width="80" height="80"></a>


Valdiney França

<a href="https://github.com/valdiney"><img src="https://avatars3.githubusercontent.com/u/3947490?s=460&u=ad7d473034d7f9ced288b13b1755a9df442eee8d&v=4" title="Paulo Vitor Carvalho Santos" width="80" height="80"></a>


David Galvão

<a href="https://github.com/davidgalvao"><img src="https://robohash.org/davidgalvao" title="David Galvão" width="80" height="80"></a>

#### Antigos Colaboradores

Marlon Trindade Ferreira

<a href="https://github.com/marlontrin20"><img src="https://avatars0.githubusercontent.com/u/8275515?s=460&v=4" title="Marlon Trindade Ferreira" width="80" height="80"></a>

Fabiano Muniz

<a href="https://github.com/fabianomuniz"><img src="https://avatars1.githubusercontent.com/u/22965696?s=460&v=4" title="Fabiano Muniz" width="80" height="80"></a>
