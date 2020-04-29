import VueRecaptcha from 'vue-recaptcha';

export const Recaptcha = {
    
    computed: {
        r_id () {
            return 0;
        } ,
        siteKey() {
            return process.env.MIX_RECAPTCHA_SITE_KEY;
        }
    },
    methods: {
        response() {
            return grecaptcha.getResponse();
        },
        reset() {
            return grecaptcha.reset();
        }
    },
    
};