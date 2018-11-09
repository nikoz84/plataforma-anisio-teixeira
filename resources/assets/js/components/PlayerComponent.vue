<template>
    <div>
        <article>
            <h3> {{tipo.nome}} </h3>
            <video src=""></video>
        </article>
        
    </div>
</template>

<script>
    export default {
        name : 'PlayerApp',
        props:['guia','download','visualizacao','tipo'],
        computed:{
            visualizarConteudo(){
                console.log(this.guia)
                console.log(this.download)
                console.log(this.visualizacao)
                console.log(this.tipo)
                this.selectTipo();
            }

        },
        methods:{
            visualizar(){

            }
        }    
    }
</script>