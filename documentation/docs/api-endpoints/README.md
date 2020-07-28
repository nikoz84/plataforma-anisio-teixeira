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
<<<<<<< HEAD
- endpoint: `/aplicativos`
  
Resposta de conteúdos paginados:

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
      {
      "id": 18,
      "user_id": 2,
      "category_id": 11,
      "canal_id": 9,
      "name": "Scribus",
      "description": "<p>O Scribus é um aplicativo de Desktop Publishing de código aberto. Versões nativas do programa estão disponíveis para Linux, Unix, Mac OS X , OS/2 e Windows, possuindo recursos avançados de layout, similares aos encontrados no Adobe PageMaker, QuarkXPress e no Adobe InDesign.</p><p>O Scribus foi desenvolvido para um layout flexibilizado e para o controle de caracteres, com a habilidade de preparar arquivos para equipamentos de qualidade profissional de imagem, sendo disponível em mais de 24 idiomas.</p><p>O Scribus também pode criar apresentações e formulários PDF animados e interativos. Os exemplos de uso incluem jornais, brochuras, cartazes e livros.</p>",
      "url": "http://wiki.softwarelivre.org/Scribus/Download",
      "options": {
      "qt_access": 2818,
      "is_featured": false
      },
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "image": null,
      "excerpt": "O Scribus é um aplicativo de Desktop Publishing de código aberto. Versões nativas do programa estão disponíveis para Linux, Unix, Mac OS X , OS/2 e Windows, possuindo recursos avançados...",
      "url_exibir": "/aplicativos-educacionais/aplicativo/exibir/18",
      "formated_date": "12 de setembro de 2019 ás 16:51",
      "user_can": null,
      "category": {
      "id": 11,
      "canal_id": 9,
      "name": "Aplicativos para Escritório",
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
      {
      "id": 43,
      "user_id": 2,
      "category_id": 22,
      "canal_id": 9,
      "name": "Drupal",
      "description":"<p>Drupal é um framework modular e um sistema de gerenciamento de conteúdo (CMS) escrito em PHP. Da mesma forma que os sistemas de gerenciamento de conteúdo mais modernos, o Drupal permite criar e organizar conteúdo, manipular a aparência, automatizar tarefas administrativas e definir permissões e papéis para usuários e colaboradores.</p>Por ser desenvolvido em PHP, o Drupal é independente de sistema operacional, no entanto requer um servidor HTTP compatível com PHP e um Servidor de Banco de Dados para funcionar.</p>O Drupal é comumente descrito como um Framework de Gerenciamento de Conteúdo, pois além de oferecer as funcionalidades básicas de um CMS ele também implementa uma série de APIs robustas e apresenta uma estrutura modular que facilita o desenvolvimento de módulos extensivos.</p>",
      "url": "http://drupal.org/download",
      "options": {
      "qt_access": 1220,
      "is_featured": false
      },
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "image": null,
      "excerpt": "Drupal é um framework modular e um sistema de gerenciamento de conteúdo (CMS) escrito em PHP. Da mesma forma que os sistemas de gerenciamento de conteúdo mais modernos, o Drupal...",
      "url_exibir": "/aplicativos-educacionais/aplicativo/exibir/43",
      "formated_date": "12 de setembro de 2019 ás 16:51",
      "user_can": null,
      "category": {
      "id": 22,
      "canal_id": 9,
      "name": "Gerenciador de Conteúdo",
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
      { 
      "id": 67,
      "user_id": 2,
      "category_id": 8,
      "canal_id": 9,
      "name": "Pysycache",
      "description": "<p>Programa educacional para crianças pequenas (de quatro a sete anos), cujo propósito é ensiná-las a manipular o mouse descobrindo uma imagem com os movimentos.</p> Possui seis temas (animais, comida, plantas, esportes, veículos e paisagens), totalizando 52 imagens. No entanto, qualquer imagem poderá ser utilizada.Roda em Windows 95, 98, NT, 2000, Millenium, XP alem de possui versão para Linux e para Mac. O site encontra-se em inglês.",
      "url": "http://download.tuxfamily.org/py4childs/pysycache/v3.1/pysycache-src-3.1c.zip",
      "options": {
      "qt_access": 936,
      "is_featured": false
      },
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "image": null,
      "excerpt": "<p>Programa educacional para crianças pequenas (de quatro a sete anos), cujo propósito é ensiná-las a manipular o mouse descobrindo uma imagem com os movimentos. Possui seis temas (animais, comida, plantas,...</p>",
      "url_exibir": "/aplicativos-educacionais/aplicativo/exibir/67",
      "formated_date": "12 de setembro de 2019 ás 16:51",
      "user_can": null,
      "category": {
      "id": 8,
      "canal_id": 9,
      "name": "Ambiente de Aprendizagem",
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
      {
      "id": 101,
      "user_id": 2,
      "category_id": 23,
      "canal_id": 9,
      "name": "Cambito",
      "description": "<p>Projeto da organização Viva Favela que tem como objetivo a diminuição da exclusão digital, especialmente entre a população de baixa renda.</p>",
      "url": "http://www.cambito.com.br/",
      "options": {
      "qt_access": 420,
      "is_featured": false
      },
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "image": null,
      "excerpt": "<p>Projeto da organização Viva Favela que tem como objetivo a diminuição da exclusão digital, especialmente entre a população de baixa renda.</p>",
      "url_exibir": "/aplicativos-educacionais/aplicativo/exibir/101",
      "formated_date": "12 de setembro de 2019 ás 16:51",
      "user_can": null,
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
      "canal": {
      "id": 9,
      "name": "Aplicativos Educacionais",
      "slug": "aplicativos-educacionais",
      "color": "#009245"
           }
        },
      {
      "id": 96,
      "user_id": 2,
      "category_id": 11,
      "canal_id": 9,
      "name": "Gnumeric",
      "description": "<p>Seu objetivo é competir com os similares comerciais, usuários do Excel deverão estar familiarizados com suas características avançadas e um sistema de plugins permite que você estenda suas capacidades com extensões GPL e opcionalmente plugins em Python, Guile e Perl permite a definição de complexas funções. É capaz de ler e gravar planilhas do Excel e diversos outros formatos. Roda em Ambiente gráfico Gnome.</p>",
      "url": "http://linux.softpedia.com/get/Office/Groupware/Gnumeric-2602.shtml",
      "options": {
      "qt_access": 891,
      "is_featured": false
      },
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "image": null,
      "excerpt": "<p>Seu objetivo é competir com os similares comerciais, usuários do Excel deverão estar familiarizados com suas características avançadas e um sistema de plugins permite que você estenda suas capacidades com...</p>",
      "url_exibir": "/aplicativos-educacionais/aplicativo/exibir/96",
      "formated_date": "12 de setembro de 2019 ás 16:51",
      "user_can": null,
      "category": {
      "id": 11,
      "canal_id": 9,
      "name": "Aplicativos para Escritório",
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


    {
      "metadata": [
      {
      "id": 8,
      "canal_id": 9,
      "name": "Ambiente de Aprendizagem",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
    },
      {
      "id": 21,
      "canal_id": 9,
      "name": "Sistemas Operacionais Livres",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
    },
      {
      "id": 9,
      "canal_id": 9,
      "name": "Ambiente de Programação",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
    },
      {
      "id": 10,
      "canal_id": 9,
      "name": "Aplicativos Educacionais",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
    },
      {   
      "id": 11,
      "canal_id": 9,
      "name": "Aplicativos para Escritório",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
    },
     {
      "id": 12,
      "canal_id": 9,
      "name": "Editor de Animação",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
    },
     {
      "id": 13,
      "canal_id": 9,
      "name": "Editor de Imagem",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
    },
      {
      "id": 20,
      "canal_id": 9,
      "name": "Editor de Vídeo",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
    },
      {
      "id": 22,
      "canal_id": 9,
      "name": "Gerenciador de Conteúdo",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
    },
      {
      "id": 14,
      "canal_id": 9,
      "name": "Gerenciador de Projetos",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
    },
      {
      "id": 18,
      "canal_id": 9,
      "name": "Gerenciador de Revistas",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
    },
      {
      "id": 23,
      "canal_id": 9,
      "name": "Portais Educacionais",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
    },
      {
      "id": 36,
      "canal_id": 9,
      "name": "Biblioteca",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
    },
      {
      "id": 37,
      "canal_id": 9,
      "name": "Editor de Áudio",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
    },
     {
      "id": 38,
      "canal_id": 9,
      "name": "Internet",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
      }
      ],
      "message": "",
      "success": true
    }


    {
    "metadata": [
      {
      "id": 8,
      "canal_id": 9,
      "name": "Ambiente de Aprendizagem",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
    },
      {
      "id": 21,
      "canal_id": 9,
      "name": "Sistemas Operacionais Livres",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
  },
      {
      "id": 9,
      "canal_id": 9,
      "name": "Ambiente de Programação",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
  },
      {
      "id": 10,
      "canal_id": 9,
      "name": "Aplicativos Educacionais",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
  },
      {
      "id": 11,
      "canal_id": 9,
      "name": "Aplicativos para Escritório",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
  },
      {
      "id": 12,
      "canal_id": 9,
      "name": "Editor de Animação",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
  },
      {
      "id": 13,
      "canal_id": 9,
      "name": "Editor de Imagem",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
  },
      {
      "id": 20,
      "canal_id": 9,
      "name": "Editor de Vídeo",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
  },
      {
      "id": 22,
      "canal_id": 9,
      "name": "Gerenciador de Conteúdo",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
  },
      {
      "id": 14,
      "canal_id": 9,
      "name": "Gerenciador de Projetos",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
  },
     {
      "id": 18,
      "canal_id": 9,
      "name": "Gerenciador de Revistas",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
  },
      {
      "id": 23,
      "canal_id": 9,
      "name": "Portais Educacionais",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
  },
     {
      "id": 36,
      "canal_id": 9,
      "name": "Biblioteca",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
  },
      {
      "id": 37,
      "canal_id": 9,
      "name": "Editor de Áudio",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
  },
      {
      "id": 38,
      "canal_id": 9,
      "name": "Internet",
      "created_at": "2019-09-12 16:51:17",
      "updated_at": null,
      "deleted_at": null,
      "sub_categories": [],
      "user_can": null
  }
    ],
    "message": "",
    "success": true
}

```
## Lista de Aplicativos

- método: `GET`
- endpoint: `/aplicativos/{id}`
  

## Lista de Autenticação
- método: `POST`
- endpoint: `/auth/login`
- endpoint: `/auth/cadastro`
- endpoint: `/auth/recuperar-senha`
- endpoint: `/auth/modificar-senha/{token}`

- método: `GET`
- endpoint:  `/auth/verificar/{token}`
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
  
=======
- endpoint: `/api-v1/aplicativos`
>>>>>>> ed70259ae14bd2c52ad17388cabf33e2972caf85
