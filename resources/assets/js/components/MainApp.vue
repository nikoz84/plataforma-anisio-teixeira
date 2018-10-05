<template>
    
    <div>
        <nav-app></nav-app>
        <main class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Example Component</div>

                        <div class="panel-body">
                            I'm an example component!
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer-app></footer-app>
    </div>
</template>

<script>
import NavApp from './NavComponent.vue';
import FooterApp from './FooterComponent.vue';

export default {
    name : 'main-app',
    components:{
        NavApp, FooterApp
    },
    mounted() {
        console.log('Component mounted.')
        axios.get('/api-v1/conteudos')
        .then(function (response) {
            // handle success
            console.log(response);
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        })
        .then(function () {
            // always executed
        });
    }
}
</script>
