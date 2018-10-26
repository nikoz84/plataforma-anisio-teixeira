
export default class Http {
    constructor(){
        this.endpoint = '/api-v1';
        this.headersData = { headers: { Authorization: "Bearer " + localStorage.token }};
        
    }
    async getDataFromIdCanal(idCanal,limit, page){
        try{
            let url = this.getCanal(idCanal,limit, page);
            return await axios.get(url, this.data);
        } catch (error){
            return await error.response;
        } 
        
    }
    async getDataFromUrl(url = ''){
        try{
            return await axios.get( this.endpoint + url, this.data);
        }catch (error){
            return await error.response;
        }
    }
    async search(termo, limit, page){
        
        try {
            return await this.http.get(`${this.url}/search/termo/${termo}/limit/${limit}/page/${page}`, this.data);
        } catch (error)
        {
            return await error.response;
        }
    }
    async postData(url, data){
        try {
            let urlPost = this.endpoint + url;
            return await axios.post( urlPost, data, this.headersData);
        } catch (error) {
            return await error.response;
        }
    }
    async putData(url, data){
        try {
            let urlPost = this.endpoint + url;
            return await axios.put( urlPost, data, this.headersData);
            
        } catch (error) {
            return await error.response;
        }
    }
    async deleteData(url, data){
        try {
            let urlPost = this.endpoint + url;
            return await axios.delete( urlPost, data, this.headersData);
            //return response.data;
        } catch (error) {
            return await error.response;
        }
    }

    getCanal(idCanal,limit, page){

        switch(true){
            case (idCanal == 5):
                return `${this.endpoint}/conteudos?site=true&limit=${limit}&page=${page}`;
            break;
            case (idCanal == 9):
                return `${this.endpoint}/aplicativos?limit=${limit}&page=${page}`;
            break;
            default:
                return `${this.endpoint}/conteudos?canal=${idCanal}&limit=${limit}&page=${page}`;     
        }
    }
}

