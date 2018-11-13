<template>
    <div>
        <article class="panel panel-default" v-bind:id="item.id">
            <div class="panel-body">
                <figure class="figure">
                    
                  <img width="250" height="150" v-bind:src="getImage" alt="imagem destacada" srcset="">
                </figure>
                <router-link :to="{ name: 'Exibir', params: { slug: this.$route.params.slug, id: item.id }}"
                            aria-label="Título" 
                            v-bind:title="'Nome do aplicativo: ' + title">
                    <h4>{{ title }}</h4>
                </router-link>
                
            </div>
        </article>
    </div>
</template>
<script>

export default {
    name: 'SimpleCard',
    props:{
        item: Object
    },
    computed:{
        title(){
            return (this.item.name) ? this.item.name : this.item.title;
        },
        getImage(){
            let image = '/img/fundo-padrao.svg';
            if(this.item.id && localStorage.idCanal == 9){
                image = `/storage/conteudos/aplicativos-educacionais/imagem-associada/${this.item.id}.jpg`;    
            }else if(this.item.id && localStorage.idCanal == 1){
                let random = Math.floor(Math.random() * 6) + 3; 
                image = `/storage/conteudos/conteudos-digitais/imagem-associada/sinopse/${this.item.id}.0${random}.jpg`;
            }
            return image; 
        }
    },
    created(){
        
    }
    
}    
</script>
<style lang="scss" scoped>

.panel-default{
    border-top-color: #333;
    border-top-width: 3px;

}
</style>
