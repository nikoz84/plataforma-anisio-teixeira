# PLATAFORMA ANÍSIO TEIXEIRA

O Ambiente Educacional Web – AEW é um projeto de aprendizagem (Baseado em Laravel 5.8) voltado ao compartilhamento de conteúdos digitais através de licenças livres, disponibilizado na internet no endereço (http://pat.educacao.ba.gov.br) para acesso e utilização de todos.

Você poderá criar canais dinámicos, conteúdos digitais, aplicativos educacionais e sites temáticos.

## SOFTWARE LIVRE

Estamos liberando o código da aplicação para cumprir com o propósito para o qual foi criado o Ambiente Educacional Web, ser um software livre, para que qualquer pessoa ou também outras secretarias de educação no Brasil sejam parte deste projeto aberto para a comunidade de desenvolvimento, por isso o convidamos a instalar o aplicativo em seu servidor local.

## COMO ESTA IMPLEMENTADO

Criamos uma API RESTFUL que se comunica com frontend feito em VUE.js permitindo desacoplar as camadas de frontend do backend:

- Backend - PHP 8.0+
- Backend - Laravel Framework 9.*
- Backend - Servidor Apache 2.2+
- Backend - Banco de dados Postgres 9.5+
- Frontend - VUE JS 2.6, Quasar Framework 1.9+

## COMO INSTALAR

Faça uma copia do arquivo .env.example, e renomeie para .env. 
Neste arquivo você vai adicionar as seguintes configurações:

- Criar banco de dados
- APP_KEY: variavel global de verificação da aplicação em base 64: `php artisan key:generate;`
- JWT_SECRET: chave para a autenticação com Json Web Token: `php artisan jwt:secret;`
- Também será adicionado um link simbólico da pasta public na pasta storage/app/public: `php artisan storage:link`
- Para editar os componentes do Laravel mail que criará uma pasta em /resources/views/vendor/mail `php artisan vendor:publish --tag=laravel-mail`
- Lembre dar as permissões para o usuário apache para a pasta storage, em UBUNTU seria:

`sudo chgrp -R www-data storage bootstrap/cache`
`sudo chmod -R ug+rwx storage bootstrap/cache`

### Instalar as dependências do laravel com composer:

`composer install`

### Se tiver problemas com a instalação das dependencias verifique as extensões de PHP

`sudo apt install php8.*-tokenizer php8.*-dom php8.*-mbstring php8.*-pgsql`

### Instalar as dependências do Vuejs com npm, lembre ter instalado o NODEJS:

`npm install`

### Crie o esquema do banco de dados no Postgresql com o comando:

`$ php arstisan migrate`

Agora podemos arrancar o servidor embutido do framework:

`$ php artisan serve`
<br>
### Links úteis
<hr>

[Novas funcionalidades](https://github.com/nikoz84/plataforma-anisio-teixeira/blob/master/Versão.md) <br>
[Como criar tags](https://github.com/nikoz84/plataforma-anisio-teixeira/blob/master/TAGS.md) <br>
[Git Flow](https://blog.betrybe.com/git/git-flow/)

