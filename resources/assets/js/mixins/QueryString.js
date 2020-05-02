
export const QueryString = {
    
    methods: {
        setQueryString(key, value) {
            let path = `/${this.$route.params.slug}/listar`;
            let query = this.$route.query;
            
            switch (key) {
                case 'ordenar':
                    let ordenar = query.ordenar ? value : query.ordenar;
                    break;
                case 'componentes':
                    let componentes = value ? value : query.ordenar;
                    break;
                case 'categoria':
                    let categoria = value ? value : query.ordenar;
                    break;
                default:
                    break;
            }
            this.$router.replace({
                path,
                query: { ordenar, componentes, categoria }
            });
        }

    },
    
};