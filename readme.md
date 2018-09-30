# plataforma-anisio-teixeira

Plataforma Anísio Teixera é uma plataforma de codigo aberto da Secretaria da Educação do Estado da Bahia.

O Plataforma Anísio Teixeira – PAT é um projeto de aprendizagem (baseado em LARAVEL FRAMEWORK de PHP) voltado ao compartilhamento de conteúdos digitais através de licenças livres, disponibilizado na internet no endereço (http://pat.educacao.ba.gov.br) para acesso e utilização de todos.

Você poderá criar canais de forma dinâmica, conteúdos digitais, aplicativos educaionais em diferentes categorias.  

SOFTWARE LIVRE
Estamos liberando o código da aplicação para cumprir com o propósito para o qual foi criado o ex Ambiente Educacional Web agora Plataforma Anísio Teixeira, ser um software livre, para que qualquer pessoa ou também outras secretarias de educação no Brasil sejam parte deste projeto aberto para a comunidade de desenvolvimento, por isso o convidamos a instalar o aplicativo em seu servidor local para testes ou para produção. Serão Liberadas diferentes versões para que o software possa ser distribuido.

## COMO ESTA IMPLEMENTADO

* PHP (7.0 ou superior)
* Laravel Framework (5.5 ou superior)
* Postgresql (9.5 ou superior) com suporte a JSONB e Full Text Search
* Vuejs (2.5 ou superior) camada do Front-End para uma melhor experiencia de usuário
* Implentação de API restful api-v1
* Templates Blade para redenrização desde o servidor (SSR)

## BANCO DE DADOS

Se otimizaram as tabelas para melhorar a performance da aplicação para evitar aumentar a quantidade de tabelas para criar um objeto.

O formato JSONB vai ajudar para escalar a aplicação e evitar criar mais tabelas para representar um objeto.

Postgresql tem embutido um sistema de buscas por texto completo (FULL TEXT SEARCH) o que ajudará a:

- Buscar por tags, título, fontes, autores e descrição; cada um com um peso específico. Exemplo: tags (A), titulo (A), fontes (B), autores(C), descrição (D).
- Indices invertidos (GIN index). Este é o coração da busca o que permitira que a busca seja mais rápida.
- Uso de Extensão UNACCENT().
  
## INSTALAÇÃO

Clone a aplicação desde o repositório em GitHub

``$ git clone https://github.com/nikoz84/plataforma-anisio-teixeira.git``

Instale as dependencias do Framework Laravel e da aplicação:

 `` $ composer install ``

Corra o servidor de desenvolvimento embutido:

``$ php artisan serve``

No navegador de internet escreva:

``http://127.0.0.1:8000``

Instale as dependencias de desenvolvimento do FRONTEND:

 `` $ npm install ``

