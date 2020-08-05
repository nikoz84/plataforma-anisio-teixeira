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
      "id": 86,
      "user_id": 2,
      "category_id": 20,
      "canal_id": 9,
      "name": "xVideoServiceThief",
      "description": "Com xVideoServiceThief você baixa vídeos de mais de 40 servidores e os salva nos formatos mais populares de serem visualizados em praticamente todos os players existentes, além de poder fazer downloads simultâneos de diferentes sites. Converte nos seguintes formatos: AVI, MPEG1, MPEG2, WMV, MP4, 3GP; Extrai o áudio dos arquivos para MP3; Acessa sites de música como o MP3tube; Configurações personalizáveis; Gratuito e com código aberto. Possui Versões para Mac, Linux e Windows.\r\nObs.: Site oficial explicativo em inglês.",
      "url": "http://xviservicethief.sourceforge.net/index.php?action=downloads",
      "options": {
          "qt_access": 2089,
          "is_featured": false
      },
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "image": null,
      "excerpt": "Com xVideoServiceThief você baixa vídeos de mais de 40 servidores e os salva nos formatos mais populares de serem visualizados em praticamente todos os players existentes, além de poder fazer...",
      "url_exibir": "/aplicativos-educacionais/aplicativo/exibir/86",
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
    }
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
    }
```

## Lista do aplicativo educacional por ID

- método: `GET`
- endpoint: `/aplicativos/{id}`
```json

"metadata": {
      "id": 84,
      "user_id": 2,
      "category_id": 23,
      "canal_id": 9,
      "name": "Portal do Professor",
      "description": "O Portal do Professor disponibilizado na rede pelo MEC possui grande quantidade de recursos tecnológicos além de aulas, softwares, jornais, e conteúdos pedagógicos.\r\nE ajuda a todas os professores a fazerem um plano de aula para que os seus alunos estejam bem informados e consigam entender melhor as matérias. O portal do professor web proporciona dicas que melhoram o desempenho dos alunos que possuem dificuldades de aprendizagem.",
      "url": "http://portaldoprofessor.mec.gov.br/index.html",
      "options": {
        "qt_access": 2907,
        "is_featured": false
      },
      "created_at": "2019-09-12 16:51:17",
      "updated_at": "2020-07-30 14:49:45",
      "deleted_at": null,
      "image": null,
      "excerpt": "O Portal do Professor disponibilizado na rede pelo MEC possui grande quantidade de recursos tecnológicos além de aulas, softwares, jornais, e conteúdos pedagógicos.\r\nE ajuda a todas os professores a...",
      "url_exibir": "/aplicativos-educacionais/aplicativo/exibir/84",
      "formated_date": "12 de setembro de 2019 ás 16:51",
      "user_can": null,
      "tags": [
        {
            "id": 261,
            "name": "aprendizagem",
            "user_can": null
        },
        {
            "id": 324,
            "name": "aula",
            "user_can": null
        },
        {
            "id": 843,
            "name": "jornais",
            "user_can": null
        },
        {
            "id": 325,
            "name": "mec",
            "user_can": null
        },
        {
            "id": 326,
            "name": "pedagógicos",
            "user_can": null
        },
        {
            "id": 323,
            "name": "plano",
            "user_can": null
        },
        {
            "id": 322,
            "name": "prefessor",
            "user_can": null
        },
        {
            "id": 179,
            "name": "softwares",
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
        "sub_categories": [],
        "user_can": null
      },
      "user": {
        "id": 2,
        "name": "Rede Anísio Teixeira",
        "is_admin": false,
        "image": null,
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
- keys: `email`, `password`, `recaptcha`

```json

{
"metadata": {
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpLXYxXC9hdXRoXC9sb2dpbiIsImlhdCI6MTU5NjE0MDEzNiwiZXhwIjoxNTk2MTYxNzM2LCJuYmYiOjE1OTYxNDAxMzYsImp0aSI6IlAxbUg5aDVlSnFzWk1rOVYiLCJzdWIiOjExMzEsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEiLCJ1c2VyIjp7Im5hbWUiOiJOaWNvbFx1MDBlMXMgRGFuaWVsIFJvbWVybyBIZXJuXHUwMGUxbmRleiIsImlkIjoxMTMxLCJyb2xlIjoxLCJpc19hZG1pbiI6ZmFsc2V9fQ.JCSqGmniow8p8RMxQNex-KC2XYiOE46M9QB4JM93LlQ",
    "token_type": "bearer",
    "expires_in": 21600
},
"message": "",
"success": true
}

```

## Cadastro
- método: `POST`
- endpoint: `/auth/cadastro`
- keys: `email`, `password`, `confirmation` ,`recaptcha`

```json

{
    "errors": {
        "email": [
            "E-mail já está em uso."
        ]
    },
    "message": "Verifique os dados fornecidos",
    "success": false
}

```

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

- Resposta de Conteúdo Lista de Options Paginado:  

  ```json
  {
    "success": true,
    "options": null
  }                        
  ```
## Lista de Tags
- método: `GET`
- endpoint: `/tags/{id}`
  
```json
{
    "metadata": {
        "id": 84,
        "name": "web",
        "searched": 4109,
        "created_at": "2019-09-12 16:51:17",
        "updated_at": "2019-09-07 02:09:28",
        "deleted_at": null,
        "user_can": null
    },
    "message": "",
    "success": true
}

```