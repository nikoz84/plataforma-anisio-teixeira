
export default class Http {
    constructor(){
        this.api = '/api-v1';
    }
    async getDataFromIdCanal( idCanal, params = {}){
        try{
            let url = this.getCanal( idCanal );
            return await axios.get( url, params );
        } catch (error){
            return await error.response;
        } 
        
    }
    async getDataFromUrl(endPoint = '', params = {}){
        try{
            let url = `${this.api}${endPoint}`;
            return await axios.get( url , {params});
        }catch (error){
            return await error.response;
        }
    }
    async getDataWithTokenUrl(endPoint = '', params= {}){
        try{
            let url = `${this.api}${endPoint}`;
            return await axios.get( url, {params} );
        }catch (error){
            return await error.response;
        }
    }
    async postData(endPoint = '', params ={}){
        try {
            let urlPost = `${this.api}${endPoint}`;
            return await axios.post(urlPost, params);
        } catch (error) {
            return await error.response;
        }
    }
    async putData(endPoint, params){
        try {
            let urlUpdate = `${this.api}${endPoint}`;
            return await axios.put( urlUpdate, {params});
        } catch (error) {
            return await error.response;
        }
    }
    async deleteData(endPoint, params){
        try {
            let urlDelete = `${this.api}${endPoint}`;
            return await axios.delete( urlDelete, {params});
        } catch (error) {
            return await error.response;
        }
    }

    getCanal(idCanal){

        switch(true){
            case (idCanal == 5):
                return `${this.api}/conteudos/sites`;
                break;
            case (idCanal == 6):
                return `${this.api}/conteudos`;
                break;    
            case (idCanal == 9):
                return `${this.api}/aplicativos`;
                break;
            default:
                return `${this.api}/conteudos?canal=${idCanal}&site=false`;
        }
    }
}



