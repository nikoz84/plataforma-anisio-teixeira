## LISTA DE LICENÇAS

- método: `GET`
- endpoint: `/licencas`
- Resposta do Conteúdo Paginado

```json
"paginator": {
    "current_page": 1,
    "data": [
    {
    "id": 1,
    "parent_id": null,
    "name": "Outros",
    "description": "Outros...",
    "site": null,
    "created_at": "2019-09-12 16:51:17",
    "updated_at": "2019-09-12 16:51:17",
    "deleted_at": null,
    "user_can": null,
    "image": "http://127.0.0.1:8000/storage/conteudos/conteudos-digitais/imagem-associada/licencas/",
    "childs": []
    },
 {
    "id": 3,
    "parent_id": null,
    "name": "Todos direitos reservados (Copyright)",
    "description": "Apenas você terá autonomia para ceder ou comercializar esta obra. O arquivo desse conteúdo não será disponibilizado para download na página",
    "site": null,
    "created_at": "2019-09-12 16:51:17",
    "updated_at": "2019-09-12 16:51:17",
    "deleted_at": null,
    "user_can": null,
    "image": "http://127.0.0.1:8000/storage/conteudos/conteudos-digitais/imagem-associada/licencas/",
    "childs": []
    },
{
    "id": 4,
    "parent_id": null,
    "name": "Domínio público",
    "description": "A obra ficará livre para ser distribuída sem fins comerciais",
    "site": null,
    "created_at": "2019-09-12 16:51:17",
    "updated_at": "2019-09-12 16:51:17",
    "deleted_at": null,
    "user_can": null,
    "image": "http://127.0.0.1:8000/storage/conteudos/conteudos-digitais/imagem-associada/licencas/",
    "childs": []
     },
{
    "id": 5,
    "parent_id": null,
    "name": "GPL",
    "description": "General Public License (Licença Pública Geral), GNU GPL ou simplesmente GPL, é a designação da licença para software livre idealizada por Richard Matthew Stallman em 1989, no âmbito do projeto GNU da Free Software Foundation (FSF).",
    "site": "http://gplv3.fsf.org/",
    "created_at": "2019-09-12 16:51:17",
    "updated_at": "2019-09-12 16:51:17",
    "deleted_at": null,
    "user_can": null,
    "image": "http://127.0.0.1:8000/storage/conteudos/conteudos-digitais/imagem-associada/licencas/",
    "childs": []
    },
{
    "id": 2,
    "parent_id": null,
    "name": "Creative Commons",
    "description": "Qualquer pessoa poderá copiar e distribuir essa obra, desde que atribuam o crédito da mesma. O arquivo desse conteúdo será disponibilizado para download na página",
    "site": "https://creativecommons.org",
    "created_at": "2019-09-12 16:51:17",
    "updated_at": "2019-09-12 16:51:17",
    "deleted_at": null,
    "user_can": null,
    "image": "http://127.0.0.1:8000/storage/conteudos/conteudos-digitais/imagem-associada/licencas/",
    "childs": [
{
    "id": 6,
    "parent_id": 2,
    "name": "Atribuição CC BY",
    "description": "Esta licença permite que outros distribuam, remixem, adaptem e criem a partir do seu trabalho, mesmo para fins comerciais, desde que lhe atribuam o devido crédito pela criação original. É a licença mais flexível de todas as licenças disponíveis. É recomendada para maximizar a disseminação e uso dos materiais licenciados.",
    "site": "http://creativecommons.org/licenses/by/4.0",
    "created_at": "2019-09-12 16:51:17",
    "updated_at": "2019-09-12 16:51:17",
    "deleted_at": null,
    "user_can": null,
    "image": "http://127.0.0.1:8000/storage/conteudos/conteudos-digitais/imagem-associada/licencas/"
    },
{
    "id": 7,
    "parent_id": 2,
    "name": "Atribuição-CompartilhaIgual CC BY-SA",
    "description": "Esta licença permite que outros remixem, adaptem e criem a partir do seu trabalho, mesmo para fins comerciais, desde que lhe atribuam o devido crédito e que licenciem as novas criações sob termos idênticos. Esta licença costuma ser comparada com as licenças de software livre e de código aberto CopyLeft. Todos os trabalhos novos baseados no seu terão a mesma licença, portanto quaisquer trabalhos derivados também permitirão o uso comercial. Esta é a licença usada pela Wikipédia e é recomendada para materiais que seriam beneficiados com a incorporação de conteúdos da Wikipédia e de outros projetos com licenciamento semelhante.",
    "site": "http://creativecommons.org/licenses/by-sa/4.0",
    "created_at": "2019-09-12 16:51:17",
    "updated_at": "2019-09-12 16:51:17",
    "deleted_at": null,
    "user_can": null,
    "image": "http://127.0.0.1:8000/storage/conteudos/conteudos-digitais/imagem-associada/licencas/"
    },
{
    "id": 8,
    "parent_id": 2,
    "name": "Atribuição-SemDerivações CC BY-ND",
    "description": "Esta licença permite a redistribuição, comercial e não comercial, desde que o trabalho seja distribuído inalterado e no seu todo, com crédito atribuído a você.",
    "site": "http://creativecommons.org/licenses/by-nd/4.0",
    "created_at": "2019-09-12 16:51:17",
    "updated_at": "2019-09-12 16:51:17",
    "deleted_at": null,
    "user_can": null,
    "image": "http://127.0.0.1:8000/storage/conteudos/conteudos-digitais/imagem-associada/licencas/"
    },
{
    "id": 9,
    "parent_id": 2,
    "name": "Atribuição-NãoComercial CC BY-NC",
    "description": "Esta licença permite que outros remixem, adaptem e criem a partir do seu trabalho para fins não comerciais, e embora os novos trabalhos tenham de lhe atribuir o devido crédito e não possam ser usados para fins comerciais, os usuários não têm de licenciar esses trabalhos derivados sob os mesmos termos.",
    "site": "http://creativecommons.org/licenses/by-nc/4.0",
    "created_at": "2019-09-12 16:51:17",
    "updated_at": "2019-09-12 16:51:17",
    "deleted_at": null,
    "user_can": null,
    "image": "http://127.0.0.1:8000/storage/conteudos/conteudos-digitais/imagem-associada/licencas/"
    },
{
    "id": 10,
    "parent_id": 2,
    "name": "Atribuição-NãoComercial-CompartilhaIgual CC BY-NC-SA",
    "description": "Esta licença permite que outros remixem, adaptem e criem a partir do seu trabalho para fins não comerciais, desde que atribuam a você o devido crédito e que licenciem as novas criações sob termos idênticos.",
    "site": "http://creativecommons.org/licenses/by-nc-sa/4.0",
    "created_at": "2019-09-12 16:51:17",
    "updated_at": "2019-09-12 16:51:17",
    "deleted_at": null,
    "user_can": null,
    "image": "http://127.0.0.1:8000/storage/conteudos/conteudos-digitais/imagem-associada/licencas/"
},
    {
    "id": 12,
    "parent_id": 2,
    "name": "Atribuição CC 0",
    "description": "Esta licença significa que o autor que associou uma obra a este documento dedicou a obra ao domínio público, renunciando a todos os seus direitos ao trabalho em todo o mundo sob a lei de direitos de autor, incluindo todos os direitos conexos, na medida do permitido por lei, permitindo copiar, modificar, distribuir e executar a obra, mesmo para fins comerciais, sem pedir permissão. Ver Outras Informações abaixo.",
    "site": "https://creativecommons.org/choose/zero",
    "created_at": "2019-09-12 16:51:17",
    "updated_at": "2019-09-12 16:51:17",
    "deleted_at": null,
    "user_can": null,
    "image": "http://127.0.0.1:8000/storage/conteudos/conteudos-digitais/imagem-associada/licencas/"
    },
{
    "id": 11,
    "parent_id": 2,
    "name": "Atribuição-NãoComercial-SemDerivados CC BY-NC-ND",
    "description": "Esta é a mais restritiva das nossas seis licenças principais, só permitindo que outros façam download dos seus trabalhos e os compartilhem desde que atribuam crédito a você, mas sem que possam alterá-los de nenhuma forma ou utilizá-los para fins comerciais.",
    "site": "http://creativecommons.org/licenses/by-nc-nd/4.0",
    "created_at": "2019-09-12 16:51:17",
    "updated_at": "2019-09-12 16:51:17",
    "deleted_at": null,
    "user_can": null,
    "image": "http://127.0.0.1:8000/storage/conteudos/conteudos-digitais/imagem-associada/licencas/"
        }
    ]
},

    {
    "id": 13,
    "parent_id": null,
    "name": "MIT",
    "description": "A permissão é concedida, gratuitamente, a qualquer pessoa que obtenha uma cópia deste software e dos arquivos de documentação associados (o \"Software\"), para lidar com o Software sem restrições, incluindo, sem limitação, os direitos de usar, copiar, modificar, mesclar , publicar, distribuir, sub-licenciar e / ou vender cópias do Software, e para permitir que as pessoas a quem o Software é fornecido a fazê-lo.",
    "site": "https://opensource.org/licenses/MIT",
    "created_at": "2019-09-12 16:51:17",
    "updated_at": "2019-09-12 16:51:17",
    "deleted_at": null,
    "user_can": null,
    "image": "http://127.0.0.1:8000/storage/conteudos/conteudos-digitais/imagem-associada/licencas/",
    "childs": []
    }
],
    "first_page_url": "http://127.0.0.1:8000/api-v1/licencas?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://127.0.0.1:8000/api-v1/licencas?page=1",
    "next_page_url": null,
    "path": "http://127.0.0.1:8000/api-v1/licencas",
    "per_page": 15,
    "prev_page_url": null,
    "to": 6,
    "total": 6
},
"message": "",
"success": true
}

```
## LISTA DE FILE

- método: `GET`
- endpoint: `/files/{directory}/{id}`
  
## LISTA MIGRAR PLANILHAS

- método: `GET`
- endpoint: `/planilhas/load-rotinas/`
- endpoint: `/planilhas/load-faculdades`
- endpoint: `/planilhas`
  


 - Resposta de Conteúdo Paginado
  
- endpoint: `/rotinas/{nivel}/{semana}`

```json

{
"metadata": [],
"message": "",
"success": true
}
```

## ROTAS PROTEGIDAS COM JSON WEB TOKEN
## USUÁRIO DEVE ESTAR LOGADO PARA ACESSAR ESSAS ROTAS.

## LISTA CATEGORIAS DOS CONTEÚDOS
- método:`POST`
- endpoint: `/categorias`
- método: `PUT`
- endpoint: `/categorias/{id}`
- método: `delete`
- endpoint: `/categorias/{id}`

## LISTA CATEGORIAS AUTENTICAÇÃO
- método: `POST`
- endpoint: `/auth/logout`
- endpoint: `/auth/refresh`
- método: `GET`
- endpoint: `/auth/links-admin`
  
## LISTA CATEGORIAS TIPOS
- método: `POST`
- endpoint: `/tipos`
- método: `PUT`
- endpoint: `/tipos/{id}`
- método: `delete`
- endpoint: `/tipos/{id}`
  
## LISTA CATEGORIAS ROLES
- método: `GET`
- endpoint: `/roles`
- endpoint: `/roles/{id}`
- endpoint: `/roles/search/term`

- método: `POST`
- endpoint: `/roles`
- método: `PUT`
- endpoint: `/roles/{id}`
- método: `DELETE`
- endpoint: `/roles/{id}`

## LISTA CATEGORIAS USUÁRIOS

- método: `GET`
- endpoint: `/usuarios/search/{termo}`
- endpoint: `/usuarios/{id}`
- endpoint: `/usuarios`

- método: `POST`
- endpoint: `/usuarios`

- método: `PUT`
- endpoint: `/usuarios/{id}`
- endpoint: `/usuarios/reset-password`

- método:`DELETE`
- endpoint:`/usuarios/{id}`

## LISTA CATEGORIAS APLICATIVOS

- método:`POST`
- endpoint:`/aplicativos`

- método:`PUT`
- endpoint:`/aplicativos/{id}`

- método: `DELETE`
- endpoint:`/aplicativos/{id}`

## LISTA CATEGORIAS APLICATIVOS CATEGORIES

- método:`POST`
- endpoint: `/aplicativos/categories`
  
- método: `PUT`
- endpoint: `/aplicativos/categories/{id}`

- método:`DELETE`
- endpoint: `/aplicativos/categories/{id}`

## LISTA CATEGORIAS TAGS

- método: `GET`
- endpoint: `/tags`
- endpoint: `/tags/search/{term}`
- endpoint: `/tags/autocomplete/{term}`

- método:`POST`
- endpoint: `/tags`

- método: `PUT`
- endpoint: `/tags/{id}`

- método: `DELETE`
- endpoint: `/tags/{id}`

## LISTA CATEGORIAS CONTEÚDOS

- método: `POST`
- endpoint: `/conteudos`
- endpoint: `/conteudos/arquivos`

- método: `PUT`
- endpoint: `/conteudos/{id}`

- método: `DELETE`
- endpoint: `/conteudos/{id}`

## LISTA CATEGORIAS CANAIS

- método: `GET`
- endpoint: `/canais`
- endpoint: `/canais/{id}`
- endpoint: `/canais/search/{term}`

- método: `POST`
- endpoint: `/canais`

- método: `PUT`
- endpoint: `/canais/{id}`

- método: `DELETE`
- endpoint: `/canais/{id}`


## LISTA CATEGORIAS LICENÇAS

- método: `GET`
- endpoint: `/licencas/search/{term}`
- endpoint: `/licencas/{id}`

- método: `POST`
- endpoint:`/licencas`

- método: `PUT`
- endpoint: `/licencas/{id}`

- método: `DELETE`
- endpoint: `/licencas/{id}`


## LISTA CATEGORIAS DENUNCIAS
- método: `GET`
- endpoint:`/contato`
- endpoint:`/contato/{id}`

-método: `DELETE`
-endpoint:`/contato/{id}`

## LISTA CATEGORIAS OPTIONS

- método: `GET`
- endpoint: `/options/id/{id}`

- método: `POST`
- endpoint: `/options`
- endpoint: `/options/destaques/`

- método: `PUT`
- endpoint: `/options/{name}`

- método: `DELETE`
- endpoint: `/options/{name}`

## LISTA CATEGORIAS ANALYTICS
- método: `GET`
- endpoint: `/analytics`

## LISTA CATEGORIAS RELATÓRIOS
- método: `GET`
- endpoint:`/usuarios/role/{role_id}`
- endpoint:`/relatorio/conteudos/{flag}`
- endpoint:`/relatorio/usuarios/role/{role_id}/{is_active}`

## LISTA CATEGORIAS SISTEMA DE PASTA
- método: `GET`
- endpoint: `/informacoes-pasta`
- endpoint: `/arquivos-existe`

- método: `POST`
- endpoint: `/converter-para-imagem`

## LISTA CATEGORIAS COMENTÁRIOS

- método: `GET`
- endpoint:`/comentarios/{id}`
- endpoint:`/comentarios/usuario/{idUsuario}/{tipo?}`
- endpoint:`/comentarios/delete/{id}`

- método: `POST`
- endpoint: `/comentarios/create`
- endpoint: `/comentarios/update/{id}`

## LISTA CATEGORIAS LIKE - DESLIKE

- método: `GET`
- endpoint: `/likes/usuario/{idUsuario}/{tipo?}`

- método: `POST`
- endpoint: `/like`
- endpoint: `/deslike`