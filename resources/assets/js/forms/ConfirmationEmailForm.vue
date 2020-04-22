<template>
    <div>
        {{this.$route.params.token}}
    </div>
</template>
<script>
export default {
    name:"ConfirmationEmail",
    data(){
        return {
            token: null
        }
    },
    beforeEnter: (to, from, next) => {
        if(!this.$router.params.token) {
            
        this.$router.push('/');
        }
        next()
    }
}
</script>