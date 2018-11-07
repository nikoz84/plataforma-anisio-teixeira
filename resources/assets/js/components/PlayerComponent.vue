<template>
    <div>
        Player
        {{ visualizarConteudo }}
        
        <video>
            
        </video>
        
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

            }

        }    
    }
</script>