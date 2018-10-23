
export default class Http {
    constructor(idCanal = null, data = {}){
        this.endpoint = '/api-v1';
        this.data = data;
        this.idCanal = idCanal;
    }
    async getData(limit = 15, page = 1){
        try{
            let url = this.getCanal(limit, page);
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
    async search(termo, limit = 15, page = 1){
        
        try {
            return await this.http.get(`${this.url}/search/termo/${termo}/limit/${limit}/page/${page}`, this.data);
        } catch (error)
        {
            return await error.response;
        }
    }
    async postData(){
        try {
            return await axios.post(this.url, this.data);
            
        } catch (error) {
            return await error.response;
        }
    }
    async putData(){
        try {
            return await axios.put(this.url,this.data);
            
        } catch (error) {
            return await error.response;
        }
    }
    async deleteData(){
        try {
            return await axios.delete(this.url,this.data);
            //return response.data;
        } catch (error) {
            return await error.response;
        }
    }

    getCanal(limit, page){

        switch(true){
            case (this.idCanal == 5):
                return `${this.endpoint}/conteudos?site=true&limit=${limit}&page=${page}`;
            break;
            case (this.idCanal == 9):
                return `${this.endpoint}/aplicativos?limit=${limit}&page=${page}`;
            break;
            default:
                return `${this.endpoint}/conteudos?canal=${this.idCanal}&limit=${limit}&page=${page}`;     
        }
    }
}

