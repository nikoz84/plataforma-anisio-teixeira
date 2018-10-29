
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
            return await axios.get( url , params);
        }catch (error){
            return await error.response;
        }
    }
    async getDataWithTokenUrl(endPoint = ''){
        try{
            let url = `${this.api}${endPoint}`;
            let data = { params:{token: localStorage.token} };
            //let config = { headers:{'Authorization':'Bearer ' + localStorage.token } };
            console.log(endPoint)
            return await axios.get( url, data );
        }catch (error){
            return await error.response;
        }
    }
    async postData(endPoint = '', params){
        try {
            let data = { params:{token: localStorage.token} };
            let urlPost = `${this.api}${endPoint}`;
            return await axios.post(urlPost, params);
        } catch (error) {
            return await error.response;
        }
    }
    async putData(endPoint, params){
        try {
            let urlUpdate = (localStorage.token) ?  `${this.api}${endPoint}&token=${token}` : `${this.api}${endPoint}`;
            return await axios.put( urlUpdate, params, this.headersData);
            
        } catch (error) {
            return await error.response;
        }
    }
    async deleteData(endPoint, params){
        try {
            let urlDelete = (localStorage.token) ?  `${this.api}${endPoint}&token=${token}` : `${this.api}${endPoint}`;
            return await axios.delete( urlDelete, params, this.headersData);
            //return response.data;
        } catch (error) {
            return await error.response;
        }
    }

    getCanal(idCanal){
        
        switch(true){
            case (idCanal == 5):
                return `${this.api}/conteudos?site=true`;
                break;
            case (idCanal == 9):
                return `${this.api}/aplicativos`;
                break;
            default:
                return `${this.api}/conteudos?canal=${idCanal}&site=false`;     
        }
    }
}

