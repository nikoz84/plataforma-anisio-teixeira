<template>
    <div>
        
        
        {{download}} {{visualizacao}}
        <!--object v-if="guia"
            v-bind:data="`/storage/conteudos/conteudos-digitais/guias-pedagogicos/` + id.guia" 
            type="application/pdf" width="100%" height="460">
            <p>Alternative text - include a link 
                <a v:bind:href="`/storage/conteudos/conteudos-digitais/guias-pedagogicos/` + id.guia">
                    to the PDF!
                </a>
            </p>
        </object -->
        <div v-if="tipo.id == 1" documento>
            <h3> {{tipo.nome}} - {{tipo.id}} </h3>
        </div>
        <div v-if="tipo.id == 2" planilha>
            <h3> {{tipo.nome}} - {{tipo.id}} </h3>
        </div>
        <div v-if="tipo.id == 3" apresentacao>
            <h3> {{tipo.nome}} - {{tipo.id}} </h3>
        </div>
        <div v-if="tipo.id == 4" audio>
            <h3> {{tipo.nome}} - {{tipo.id}} </h3>
        </div>
        <div class="col-sm-8" v-if="tipo.id == 5" video>
            <h3> {{tipo.nome}} - {{tipo.id}} </h3>
            <div align="center" class="embed-responsive embed-responsive-16by9">
                <video controls>
                    <source  class="embed-responsive-item" :src="video" type="video/webm">
                </video>
            </div>
        </div>
        <div v-if="tipo.id == 6" imagem>
            <h3> {{tipo.nome}} - {{tipo.id}} </h3>
        </div>
        <div v-if="tipo.id == 7" animacao>
            <h3> {{tipo.nome}} - {{tipo.id}} </h3>
        </div>
        <div v-if="tipo.id == 8" site>
            <h3> {{tipo.nome}} - {{tipo.id}} </h3>
        </div>
        <div v-if="tipo.id == 9" software>
            <h3> {{tipo.nome}} - {{tipo.id}} </h3>
        </div>
        <div v-if="tipo.id == 10" sequencia>
            <h3> {{tipo.nome}} - {{tipo.id}} </h3>
        </div>
    </div>
</template>

<script>
    export default {
        name : 'PlayerApp',
        props:['guia','download','visualizacao','tipo','id'],
        mounted(){
            //this.$refs.videoRef.src = ``;
            //console.log()
        },
        computed:{
            visualizarConteudo(){
                console.log(this.guia)
                console.log(this.download)
                console.log(this.visualizacao)
                console.log(this.tipo)
                console.log(this.id)
                
            },
            video(){
                return `/storage/conteudos/conteudos-digitais/visualizacao/${this.visualizacao}`;
            }

        },
        methods:{
            visualizar(){

            }
        }    
    }
</script>