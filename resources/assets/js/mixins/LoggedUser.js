
export const LoggedUser = {
    
    methods: {

        can() {
            let can = null;
            if(localStorage.user){
                const user = JSON.parse(localStorage.getItem('user'));
                let role = user.role;
                can = this.isLogged && role === 1 || role === 2 || role === 3;
            }
            
            const slug = this.$route.params.slug;
            if(slug == 'contato'){
                return false;
            }
            
            return can;
            
        }

    },
    
};