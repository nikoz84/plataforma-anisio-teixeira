---
sidebar: auto
---

A plataforma segue a arquitetura dos aplicativos Laravel. Com o propósito de agrupar funcionalidades de respostas existe o trait `App\Traits\ApiResponser` ele é encarregado dos métodos de respostas como `showOne()`, `showAll()`, `showAsPaginator()`, `fetchForSelect()`, `successResponse()`, `errorResponse()`.

Todos os controladores herdam da clase `App\Http\Controllers\ApiController`, assim podem usar os métodos do Trait antes mencionado.

## URL base da API Versão 1

- raiz: `/api-v1`

## Lista conteúdos digitais

- método: `GET`
- endpoint: `/api-v1/conteudos`

Resposta de conteúdos paginados:

```json

{
  "paginator": {
    "current_page": 1,
    "data": [
        {
        "id": 10404,
        "tipo_id": 5,
        "canal_id": 6,
        "user_id": 209,
        "approving_user_id": 209,
        "license_id": 10,
        "category_id": null,
        "title": "Falando Sobre Educação Corpo, os Gestos e os Movimentos Campos de Experiência na Educação Infantil",
        "description": "<p>CONTEÚDO(S): BNCC e a Educação Infantil: Corpo de experiência , os gestos e os movimentos na Educação Infantil.OBJETIVO(S): Conhecer o campo de experiência Corpo, gestos e movimentos .Qual a síntese de aprendizagem esperada para este campo de experiência segundo a BNCC",
        "authors": "Pita Educacional",
        "source": "youtube",
        "accessibility": "Não",
        "is_approved": true,
        "is_featured": false,
        "is_site": false,
        "qt_downloads": 2,
        "qt_access": 7,
        "options": {
          "site": ""
        },
        "created_at": "2019-09-06 13:43:32",
        "updated_at": "2020-07-15 07:00:46",
        "deleted_at": null,
        "image": "http://pat.des/storage/conteudos/conteudos-digitais/imagem-associada/sinopse/10404.08.jpg",
        "excerpt": "CONTEÚDO(S): BNCC e a Educação Infantil: Corpo de experiência , os gestos e os movimentos na Educação Infantil.OBJETIVO(S): Conhecer o campo de experiência Corpo, gestos e movimentos .Qual a síntese...",
        "short_title": "Falando Sobre Educação Corpo, os Gestos e...",
        "url_exibir": "/recursos-educacionais/conteudo/exibir/10404",
        "user_can": null,
        "arquivos": {
          "download": {
            
          },
          "visualizacao": {
            
          },
          "guias-pedagogicos": {
            
          }
        },
        "formated_date": "06 de setembro de 2019 ás 13:43",
        "title_slug": "falando-sobre-educacao-corpo-os-gestos-e-os-movimentos-campos-de-experiencia-na-educacao-infantil",
        "canal": {
          "id": 6,
          "name": "Recursos Educacionais",
          "slug": "recursos-educacionais",
          "color": "#0071BC"
        },
        "tipo": {
          "id": 5,
          "name": "Vídeo",
          "icon": "video",
          "user_can": null,
          "search_url": "/recursos-educacionais/listar?tipos=5"
        }
      }
    ]
  },
  "first_page_url": "/conteudos?&page=1",
    "from": 1,
    "last_page": 1565,
    "last_page_url": "/conteudos?&page=1565",
    "next_page_url": "/conteudos?&page=2",
    "path": "/conteudos?",
    "per_page": 6,
    "prev_page_url": null,
    "to": 6,
    "total": 9387
  },
  "message": "",
  "success": true
}

```

## Lista aplicativos educacionais

- método: `GET`
- endpoint: `/aplicativos`
  
Resposta de aplicativos educacionais paginados:

```json

{
 "paginator": {
   "current_page": 1,
   "data": [
       {
      "id": 31,
      "user_id": 2,
      "category_id": 20,
      "canal_id": 9,
      "name": "Kdenlive",
      "description": "<p>Kdenlive é um editor de vídeo não-linear.</p> **Obs.:** Disponivel para plataformas Linux e Mac.",
      "url": "https://kdenlive.org",
      "options": {
      "qt_access": 4598,
      "is_featured": false
          },
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "image": null,
      "excerpt": "<p>Kdenlive é um editor de vídeo não-linear.</p>**Obs.:** Disponivel para plataformas Linux e Mac.",
      "url_exibir": "/aplicativos-educacionais/aplicativo/exibir/31",
      "formated_date": "12 de setembro de 2019 ás 16:51",
      "user_can": null,
      "category": {
      "id": 20,
      "canal_id": 9,
      "name": "Editor de Vídeo",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
            },
      "canal": {
      "id": 9,
      "name": "Aplicativos Educacionais",
      "slug": "aplicativos-educacionais",
      "color": "#009245"
            }
        },
    ],
    "first_page_url": "/aplicativos?categoria=&limit=6&page=1",
    "from": 1,
    "last_page": 14,
    "last_page_url": "/aplicativos?categoria=&limit=6&page=14",
    "next_page_url": "/aplicativos?categoria=&limit=6&page=2",
    "path": "/aplicativos?categoria=&limit=6",
    "per_page": 6,
    "prev_page_url": null,
    "to": 6,
    "total": 84
  },
  "message": "",
  "success": true
```

## Lista do aplicativo educacional por ID

- método: `GET`
- endpoint: `/aplicativos/{id}`

Resposta:
```json

{
  "metadata": {
    "id": 83,
    "user_id": 2,
    "category_id": 23,
    "canal_id": 9,
    "name": "Webeduc",
    "description": "Neste portal você encontrará material de pesquisa, objetos de aprendizagem e outros conteúdos educacionais de livre acesso.",
    "url": "http://webeduc.mec.gov.br/",
    "options": {
      "qt_access": 512,
      "is_featured": false
    },
    "created_at": "2019-09-12 16:51:17",
    "updated_at": "2020-07-28 17:35:02",
    "deleted_at": null,
    "image": "http://pat.des/storage/conteudos/aplicativos-educacionais/imagem-associada/83.jpg",
    "excerpt": "Neste portal você encontrará material de pesquisa, objetos de aprendizagem e outros conteúdos educacionais de livre acesso.",
    "url_exibir": "/aplicativos-educacionais/aplicativo/exibir/83",
    "formated_date": "12 de setembro de 2019 ás 16:51",
    "user_can": null,
    "tags": [
      {
        "id": 261,
        "name": "aprendizagem",
        "user_can": null
      },
      {
        "id": 316,
        "name": "conteúdos",
        "user_can": null
      },
      {
        "id": 180,
        "name": "educacionais",
        "user_can": null
      },
      {
        "id": 321,
        "name": "livre",
        "user_can": null
      },
      {
        "id": 320,
        "name": "objeto",
        "user_can": null
      },
      {
        "id": 319,
        "name": "pesquisa",
        "user_can": null
      }
    ],
    "category": {
      "id": 23,
      "canal_id": 9,
      "name": "Portais Educacionais",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [
        
      ],
      "user_can": null
    },
    "user": {
      "id": 2,
      "name": "Rede Anísio Teixeira",
      "is_admin": false,
      "image": "http://pat.des/storage/conteudos/fotos-perfil/usuario",
      "user_can": null
    },
    "canal": {
      "id": 9,
      "name": "Aplicativos Educacionais",
      "slug": "aplicativos-educacionais",
      "color": "#009245"
    }
  },
  "message": "",
  "success": true
}

```

## Login
- método: `POST`
- endpoint: `/auth/login`
- keys : `email`, `password`, `recaptcha`

## Cadastro
- método: `POST`
- endpoint: `/auth/cadastro`
- keys: `email`, `password`, `confirmation` ,`recaptcha`

## Recuperar senha
- endpoint: `/auth/recuperar-senha`

## Modificar senha
- endpoint: `/auth/modificar-senha/{token}`

## Verificar token
- endpoint:  `/auth/verificar/{token}`

## Verificar email
- endpoint:  `/auth/verificar/email/{token}`
  
## Lista de Options
- método: `GET`
- endpoint: `/options/{name}`
- endpoint: `/options`

- Resposta de Conteúdo Paginado  

  ```json
  {
    "success": true,
    "options": null
  }                        
  ```
## Lista de Tags
- método: `GET`
- endpoint: `/tags/{id}`
  
