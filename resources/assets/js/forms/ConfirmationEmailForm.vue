<template>
    <div>
        {{this.$route.params.code}}
    </div>
</template>
<script>
export default {
    name:"ConfirmationEmail",
    data(){
        return {
            code: null
        }
    },
    beforeEnter: (to, from, next) => {
        if(!this.$router.params.code) {
        this.$router.push('/');
        }
        next()
    }
}
</script>