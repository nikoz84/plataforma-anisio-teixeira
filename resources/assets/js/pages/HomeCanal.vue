<template>
    <section>
        <p v-html="canal.description"></p>
        <div>
            <img src="/storage/conteudos/geral/icone-o-que.png" alt="" style="background-color: #051825;">
            <img src="/storage/conteudos/geral/icone-por-que.png" alt="" style="background-color: #051825;">
            <img src="/storage/conteudos/geral/icone-como.png" alt="" style="background-color: #051825;">
            <img src="/storage/conteudos/geral/icone-sobre-canal.png" alt="" style="background-color: #051825;">
            <ul v-if="canal.options">
                <li>O quê?</li>
                <li v-text="canal.options.complement_description.que"></li>
                <li>Por Quê?</li>
                <li v-text="canal.options.complement_description.porque"></li>
                <li>Como?</li>
                <li v-text="canal.options.complement_description.como"></li>
            </ul>
        </div>
    </section>
</template>
<script>
import { mapState } from "vuex";

export default {
  name: "HomeCanal",
  data() {
    return {
      title: "Inicio",
      description: "Aqui vai o conteúdo Inicio."
    };
  },
  computed: {
    ...mapState(["canal"])
  }
};
</script>
<style lang="scss" scoped>
/**
section{
     background: var(--color); 
}
**/
</style>