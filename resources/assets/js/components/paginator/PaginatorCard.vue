<template>

  <q-card
    class="card-hover"
    v-bind:id="item.id"
    v-if="item"
    :style="`
        margin-top: 36px;
        box-shadow: 1px 3px 3px 3px rgb(0 0 0 / 20%), 0 3px 3px rgb(0 0 0 / 14%), 0 3px 3px -2px rgb(0 0 0 / 12%) ;
  border-radius: 6px !important;    
    `"
  >

    <a
      v-if="item.slug!='blog'"
      :href="item.url_exibir"
    >
      <q-img
        href=""
        class="cursor-pointer"
        alt="imagem destacada"
        :src="getImage"
        loading="lazy"
        width="91%"
        height="auto"
        :style="`
    height: 230px;
    min-height: 230px;
    border-bottom: 5px solid #264b8f;
    border-top: 5px solid #264b8f;
    margin-top: -20px ;
    margin-left: 15px;
    margin-right: 15px;
    border-radius: 6px;
    
    
    `"
        placeholder-src="/img/fundo-padrao.svg"
      >

        {{ /* Condicional dos recursos educacionais */ }}

      </q-img>
    </a>

    <q-img
      v-if="item.slug=='blog'"
      @click="goTo(item)"
      href=""
      class="cursor-pointer"
      alt="imagem destacada"
      :src="getImage"
      loading="lazy"
      width="91%"
      height="auto"
      :style="`
    height: 230px;
    min-height: 230px;
    border-bottom: 5px solid #264b8f;
    border-top: 5px solid #264b8f;
    margin-top: -20px ;
    margin-left: 15px;
    margin-right: 15px;
    border-radius: 6px;
    
    
    `"
      placeholder-src="/img/fundo-padrao.svg"
    >

      {{ /* Condicional dos recursos educacionais */ }}

    </q-img>

    <q-card-section class="q-mb-md ">
      <q-chip
        color="petecavermelho"
        text-color="white"
        clickable
        @click="irTipoConteudo(item.tipo.id)"
      >
        {{getTipo}}
      </q-chip>

      <span v-if="item.slug=='blog'">

        <q-chip
          color="primary"
          text-color="white"
          icon="event"
          v-on="GetPostInformation(item.id)"
        >

          {{this.data_criado}}

        </q-chip>

      </span>

      <span v-if="item.slug!='blog'">
        <q-chip
          color="primary"
          text-color="white"
          icon="event"
        >
          {{criado}}
        </q-chip>
      </span>
      <q-separator
        color="#264b8f"
        v-if="item.slug!='blog'"
      />
      <div
        class="text-h6 q-mt-sm q-mb-xs text-center"
        :style="`margin-bottom: 20px; margin-top: 15%;`"
      >{{title}}

      </div>

    </q-card-section>

    <q-separator
      color="#264b8f"
      inset
      v-if="item.slug!='blog'"
    />
    <q-card-actions vertical>

      <q-expansion-item
        class="text-left"
        expand-separator
        icon="info"
        label="Mais Informações"
        v-if="item.slug!='blog'"
      >
        <q-card>
          <q-card-section>
            <span v-if="item.slug!='blog'">
              <q-chip size="sm">
                <q-avatar
                  color="petecavermelho"
                  text-color="white"
                >{{downloads}}</q-avatar>
                Downloads
              </q-chip>
            </span>
            <span v-if="item.slug!='blog'">
              <q-chip size="sm">
                <q-avatar
                  color="petecavermelho"
                  text-color="white"
                >{{item.qt_access}}</q-avatar>
                Acessos
              </q-chip>
            </span>

            <div
              class="q-mt-md"
              v-html="descricao"
            ></div>
          </q-card-section>
        </q-card>
      </q-expansion-item>
    </q-card-actions>

  </q-card>

</template>
<script>
import { Posts } from "../../components/blog";

import {
  QCard,
  QCardSection,
  QCardActions,
  QBtn,
  QImg,
  QSeparator,
  QIcon,
} from "quasar";

export default {
  name: "PaginatorCard",
  data() {
    return {
      data_criado: "",
    };
  },
  props: {
    item: Object,
    Posts: Object,
  },
  components: {
    QCard,
    QCardSection,
    QCardActions,
    QBtn,
    QImg,
    QSeparator,
    QIcon,
    Posts,
  },

  computed: {
    title() {
      let title = this.item.name ? this.item.name : this.item.title;

      return title.length > 100 ? title.substr(0, 100) + " ..." : title;
    },
    slug() {
      return this.item.canal ? this.item.canal.slug : this.item.slug;
    },
    color() {
      return this.item.canal ? this.item.canal.color : "primary";
    },
    getImage() {
      return this.item.image;
    },
    getTipo() {
      return this.item.tipo ? this.item.tipo.name : this.item.category.name;
    },
    downloads() {
      return this.item.qt_downloads
        ? this.item.qt_downloads
        : this.item.qt_downloads;
    },
    criado() {
      let criado = this.item.created_at
        ? this.item.created_at
        : this.item.created_at;

      let date = new Date(criado);
      let dataFormatada = date.toLocaleDateString("pt-BR", { timeZone: "UTC" });

      return dataFormatada;
    },
    descricao() {
      return this.item.description
        ? this.item.description
        : this.item.description;
    },
  },
  methods: {
    goTo(item) {
      if (item && item.url_exibir) {
        this.$router.push(item.url_exibir);
      } else {
        this.$router.push({
          name: "ExibirConteudo",
          params: { slug: item.slug, id: item.id, action: "exibir" },
        });
      }
    },
    irTipoConteudo(conteudoId) {
      this.$router.replace(`/recursos-educacionais/listar?tipos=${conteudoId}`);
    },

    async GetPostInformation(IdPost) {
      const { data } = await axios.get(`/posts/${IdPost}`);
      //console.log(data.metadata.created_at);
      if (data) {
        this.data_criado = data.metadata.created_at;
        // console.log(data.metadata.created_at);
        // return data.metadata.created_at;
      }
    },
  },
};
</script>
<style lang="stylus" scoped>
.q-img__image {
  & .absolute-full {
    background-color: black;
  }
}

.text-h6 {
  font-weight: bold;
}

.card-hover:hover {
  transform: translateY(5px);
}

.card-hover {
  transition: transform 0.2s ease-out;
}

.text-h6 {
  font-size: 16px;
  font-weight: 600;
}
</style>
