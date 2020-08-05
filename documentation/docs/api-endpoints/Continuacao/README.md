## LISTA DE LICENÇAS

- método: `GET`
- endpoint: `/licencas`
- Resposta do Conteúdo Paginado:

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
- endpoint: `/rotinas/{nivel}/{semana}`
- Resposta de Conteúdo Paginado:
  ```json
    {
    "paginator": {
        "current_page": 1,
        "data": [],
        "first_page_url": "/planilhas?&page=1",
        "from": null,
        "last_page": 1,
        "last_page_url": "/planilhas?&page=1",
        "next_page_url": null,
        "path": "/planilhas?",
        "per_page": 10,
        "prev_page_url": null,
        "to": null,
        "total": 0
     },
    "message": "",
    "success": true
    }
    ```json
    "metadata": {
        "rotinas": [],
        "semanas": [
            {
                "value": "semana-1",
                "label": "Semana 1"
            },
            
        ]
    },
    "message": "",
    "success": true
}
  


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