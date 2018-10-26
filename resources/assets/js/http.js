
export default class Http {
    constructor(){
        this.api = '/api-v1';
    }
    async getDataFromIdCanal(idCanal,limit, page){
        try{
            let url = this.getCanal(idCanal,limit, page);
            return await axios.get(url, this.data);
        } catch (error){
            return await error.response;
        } 
        
    }
    async getDataFromUrl(endPoint = ''){
        try{

            let url = `${this.api}/${endPoint}?token=${localStorage.token}`;
            console.warn(url);
            return await axios.get(url, this.data);
        }catch (error){
            return await error.response;
        }
    }
    
    async postData(url, data){
        try {
            let urlPost = this.api + url + `?token=${localStorage.token}`;
            return await axios.post(urlPost, data);
        } catch (error) {
            return await error.response;
        }
    }
    async putData(url, data){
        try {
            let urlPost = this.api + url + `?token=${localStorage.token}`;
            return await axios.put( urlPost, data, this.headersData);
            
        } catch (error) {
            return await error.response;
        }
    }
    async deleteData(url, data){
        try {
            let urlPost = this.api + url + `?token=${localStorage.token}`;
            return await axios.delete( urlPost, data, this.headersData);
            //return response.data;
        } catch (error) {
            return await error.response;
        }
    }

    getCanal(idCanal,limit, page){

        switch(true){
            case (idCanal == 5):
                return `${this.api}/conteudos?site=true&limit=${limit}&page=${page}`;
            break;
            case (idCanal == 9):
                return `${this.api}/aplicativos?limit=${limit}&page=${page}`;
            break;
            default:
                return `${this.api}/conteudos?canal=${idCanal}&limit=${limit}&page=${page}`;     
        }
    }
}

