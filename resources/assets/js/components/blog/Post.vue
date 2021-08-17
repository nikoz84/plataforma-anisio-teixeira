<template>
    <article class="row q-mt-sm">
        <q-card class="" v-if="post">
          
            <q-card-section class="text-center">
                <Title :title="post.title"></Title>
            </q-card-section>
            <q-card-section class="text-center">
              <small>
                  Autor: 
                  <q-badge color="secondary">{{post.author}}</q-badge>
                </small>
                <small>
                  Publicado em: 
                  <q-badge color="secondary">{{post.created_at}}</q-badge>
                </small>
              <q-separator class="q-mt-lg" />
            </q-card-section>
            <q-card-section :class="`q-ma-lg text-justify`" 
                            v-html="postContent">
            </q-card-section>
            <q-card-section>
              <TagList :items="post.categories" title="Categorias" slug="busca"></TagList>
            </q-card-section>
        </q-card>
    </article>
</template>
<script>// @ts-nocheck

import { mapState } from "vuex";
import { QCard, QCardSection, QCardActions, QChip } from "quasar";
import { Title, TagList } from "@components/shared";

export default {
  name: "Post",
  components: { Title, TagList },
  mounted() {
    //this.getPostData()
    
  },
  computed: {
    ...mapState(["post", "canal"]),
    postContent(){
      const doc = new DOMParser().parseFromString(this.post.content, "text/html");
      const body = doc.body;
      const section = document.createElement('section')

      const elements = [...body.children].map(e=>{
          e.removeAttribute('style')
          return section.appendChild(e);
      })
      
      
      return section.outerHTML
      
    }
  },
  methods:{
    getPostData(){
      const doc = new DOMParser().parseFromString(this.post.content, "text/html");
      const body = doc.body;
      const nodes = body.childNodes
      return nodes.forEach(e => {
        let element = e.removeAttribute("style")
        return element;
      })
      
    }
  }
};
</script>
<style lang="stylus">
.wp-caption .aligncenter {
  align-items: center;
}
p{
  font-size: 20px;
  display: block;
  word-break: break-word;
}
p::after{
  content: "\A";
  white-space: pre;
}
img{
  object-fit: contain;
}
</style>

