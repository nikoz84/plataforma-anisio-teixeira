<template>
    <article class="q-ma-lg">
        <q-card class="" v-if="post">
            <div :style="styleCss">
              
            </div>
            <q-card-section class="head">
                
                  <header class="q-my-md q-gutter-md">
        
                    <h1 class="text-h3 color-primary">
                      {{post.title}}
                    </h1>
                  </header>
                
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
            <q-card-section :class="`q-ma-lg text-justify wordbreak`" 
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
      section.classList.add('font-post')
      const elements = [...body.children].map(e=>{
          e.removeAttribute('style')
          return section.appendChild(e);
      })
      
      
      return section.outerHTML
      
    },
    styleCss(){
      
      return {
        'width': '100%',
        'height': '250px',
        'background-image': `url(${this.post.image})`,
        'background-repeat': 'no-repeat',
        'background-position': 'center center',
        'background-color': '#EEE',
        'background-size': '100% auto'
      }
    }
  },
  methods:{
    async getPostData(){
      const doc = await new DOMParser().parseFromString(this.post.content, "text/html");
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
