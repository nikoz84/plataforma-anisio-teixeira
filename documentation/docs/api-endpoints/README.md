---
sidebar: auto
---

A plataforma segue a arquitetura dos aplicativos Laravel. Com o propósito de agrupar funcionalidades de respostas existe o trait `App\Traits\ApiResponser` ele é encarregado dos métodos de respostas como `showOne()`, `showAll()`, `showAsPaginator()`, `fetchForSelect()`, `successResponse()`, `errorResponse()`.

Todos os controladores herdam da clase `App\Http\Controllers\ApiController`, assim podem usar os métodos do Trait antes mencionado.

## URL base da API Versão 1

- raiz: `/api-v1`

## Lista conteúdos digitais

- método: `GET`
- endpoint: `/conteudos`

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
