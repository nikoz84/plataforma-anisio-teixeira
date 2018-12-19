
export default class Http {
    constructor(){
        this.api = '/api-v1';
    }
    /**
     * Retorna dados do canal
     * @param {*} idCanal identificador do canal
     * @param {*} params parametros
     */
    async getDataFromIdCanal( idCanal, params = {}){
        try{
            let url = this.getUrlCanal( idCanal );
            return await axios.get( url, params );
        } catch (error){
            return await error.response;
        }
    }
    /**
     * Retorna dados da url fornecida
     * @param {*} endPoint url do recurso
     * @param {*} params parametros
     */
    async getDataFromUrl(endPoint = '', params = {}){
        try{
            let url = `${this.api}${endPoint}`;
            return await axios.get( url , {params});
        }catch (error){
            return await error.response;
        }
    }
    /**
     * 
     * @param {*} endPoint 
     * @param {*} params 
     */
    async getDataWithTokenUrl(endPoint = '', params= {}){
        try{
            let url = `${this.api}${endPoint}`;
            return await axios.get( url, {params} );
        }catch (error){
            return await error.response;
        }
    }
    /**
     * Criar recurso
     * @param {*} endPoint url do recurso
     * @param {*} params parametros
     */
    async postData(endPoint = '', params ={}){
        try {
            let urlPost = `${this.api}${endPoint}`;
            return await axios.post(urlPost, params);
        } catch (error) {
            return await error.response;
        }
    }
    /**
     * Atualizar dados de um recurso
     * @param {*} endPoint url do recurso
     * @param {*} params parametros
     */
    async putData(endPoint = '', params = {}){
        try {
            let urlUpdate = `${this.api}${endPoint}`;
            return await axios.put( urlUpdate, params);
        } catch (error) {
            return await error.response;
        }
    }
    /**
     * Apagar recurso
     * @param {*} endPoint url do recurso
     * @param {*} params parametros
     */
    async deleteData(endPoint = '', params = {}){
        try {
            let urlDelete = `${this.api}${endPoint}`;
            return await axios.delete( urlDelete, params);
        } catch (error) {
            return await error.response;
        }
    }
    /**
     * Retorna a url do recurso segundo o canal
     * @param {*} id identificador unico do canal
     */
    getUrlCanal(id){
        switch(true){
            case (id == 5):
                return `${this.api}/conteudos/sites`;
                break;
            case (id == 6):
                return `${this.api}/conteudos`;
                break;
            case (id == 9):
                return `${this.api}/aplicativos`;
                break;
            default:
                return `${this.api}/conteudos?canal=${id}&site=false`;
        }
    }
}



