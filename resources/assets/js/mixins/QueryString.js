
export const QueryString = {
    
    methods: {

        replaceURL(action, id) {
            let data = {};
            data[action] = id;
            const path = `/${this.$route.params.slug}/listar`;
            let query = Object.assign({}, this.$route.query, data);
            
            this.$router.push({
                path,
                query 
            });
            
        }

    },
    
};