<template>
  <div class="">
    <q-btn
      :outline="outlineThumbsUp"
      :loading="loaddingIcon"
      size="md"
      round
      color="positive"
      @click="thumbsUp()"
      title="Gostei"
      icon="thumb_up"
    >
      <q-badge v-if="this.countThumbsUp > 0" color="positive" floating>
        {{ this.shortNum(this.countThumbsUp) }}
      </q-badge>
    </q-btn>
    <q-btn
      :outline="outlineThumbsDown"
      :loading="loaddingIcon"
      size="md"
      round
      ripple
      color="negative"
      @click="thumbsDown()"
      title="Não gostei"
      icon="thumb_down"
    >
      <q-badge v-if="this.countThumbsDown > 0" color="negative" floating>
        {{ this.shortNum(this.countThumbsDown) }}
      </q-badge>
    </q-btn>
  </div>
</template>
<script>
import shorener from "number-shortener";
export default {
  name: "ThumbsMenu",
  data() {
    return {
      loaddingIcon: false,
      outlineThumbsUp: true,
      outlineThumbsDown: true,
      countThumbsDown: 0,
      countThumbsUp: 0,
      likeOrNot: null,
      countLikes: null,
      shortNum: {},
    };
  },
  created() {
    this.shortNum = shorener;
    if (localStorage.user) {
      const userLikes = JSON.parse(localStorage.user);
      this.getUserLike();
    }
    this.getCountLikes();
  },
  methods: {
    testeUsuarioLogado() {
      if (!this.$q.localStorage.user) {
        this.$q.notify({
          message: "Você precisa estar logado para realizar esta ação",
          position: "top-right",
          color: "red",
        });
        return false;
      }
      return true;
    },
    async getUserLike() {
      let resp = await axios.get(
        "/likes/conteudo/" + this.$route.params.id + "/" + this.getTipo()
      );
      if (resp.data.success) {
        this.likeOrNot = resp.data.metadata;
        if (this.likeOrNot.like) {
          this.outlineThumbsUp = false;
        }
        if (this.likeOrNot.like === false) {
          this.outlineThumbsDown = false;
        }
      }
      //console.log("likeornot", this.likeOrNot);
    },
    async getCountLikes() {
      let resp = await axios.get(
        "/likes/count/" + this.$route.params.id + "/" + this.getTipo()
      );
      if (resp.data.success) {
        this.countLikes = resp.data.metadata;
        this.countThumbsDown = this.countLikes.dislikes;
        this.countThumbsUp = this.countLikes.likes;
      }
    },
    getTipo() {
      if (this.$route.path.indexOf("/conteudo/") >= 0) {
        return "conteudo";
      } else if (this.$route.path.indexOf("/aplicativo/") >= 0) {
        return "aplicativo";
      }
      return "aplicativo";
    },
    thumbsUp() {
      if (!this.testeUsuarioLogado()) return;
      this.save(true);
      this.outlineThumbsUp = !this.outlineThumbsUp;
      if (!this.outlineThumbsUp) {
        if (!this.outlineThumbsDown) this.countThumbsDown--;
        this.outlineThumbsDown = true;
        this.countThumbsUp++;
      } else {
        this.countThumbsUp--;
      }
    },
    async thumbsDown() {
      if (!this.testeUsuarioLogado()) return;
      this.save(false);
      this.outlineThumbsDown = !this.outlineThumbsDown;
      if (!this.outlineThumbsDown) {
        if (!this.outlineThumbsUp) this.countThumbsUp--;
        this.outlineThumbsUp = true;
        this.countThumbsDown++;
      } else {
        this.countThumbsDown--;
      }
    },
    async save(likeordislike) {
      const userLikes = JSON.parse(this.$q.localStorage.user);
      this.loaddingIcon = true;
      const form = new FormData();
      form.append("tipo", this.getTipo());
      if (this.$route.path.indexOf("/conteudo/") >= 0) {
        form.append("conteudo_id", this.$route.params.id);
      } else if (this.$route.path.indexOf("/aplicativo/") >= 0) {
        form.append("aplicativo_id", this.$route.params.id);
      }

      form.append("user_id", "");
      if (likeordislike) {
        form.append("like", 1);
      } else if (likeordislike) {
        form.append("like", 0);
      }
      try {
        if (likeordislike) {
          let resp = await axios.post("/like", form);
        } else if (likeordislike == false) {
          let resp = await axios.post("/dislike", form);
        } else if (likeordislike == null) {
          let resp = await axios.delete("/dislike", form);
        }
      } catch (ex) {
        this.errors = ex.errors;
      } finally {
        this.loaddingIcon = false;
      }
      return true;
    },
  },
};
</script>
