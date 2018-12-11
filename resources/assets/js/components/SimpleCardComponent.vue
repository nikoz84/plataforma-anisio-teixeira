<template>
    <div>
        <article class="panel panel-default" v-bind:id="item.id" v-bind:style="'border-bottom-color:' + color">
            <div class="panel-heading">
                <figure class="figure">
                    <img class="img-responsive" 
                        v-bind:src="getImage" 
                        alt="imagem destacada" 
                        srcset="">
                </figure>
            </div>
            <div class="panel-body">
                <router-link :to="{ name: 'Exibir', params: { slug: slug, id: item.id }}"
                            aria-label="Título" 
                            v-bind:title="'Título: ' + title">
                    <h4 class="text-center">{{ title }}</h4>
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
        slug(){
            return this.item.canal.slug;
        },
        color(){
            return this.item.canal.color;
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
    border-right-width: 3px;
}
.panel-default .panel-heading{
    padding: 2px 2px;
}
.figure .img-responsive {
    margin: 0 auto;
}
.img-responsive{
    width: 100%;
}
</style>
