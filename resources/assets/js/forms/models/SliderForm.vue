<template>
  <div>hola mudno</div>
</template>

<script>
export default {
    name: "SliderForm",
    data(){
        return {
            slides: []
        }
    },
    created(){
        console.log(this.$route)
    },
    methods: {
        getSlides(){
            let resp = axios.get('/options/slider');

            console.log(resp);
        }
    }
}
</script>