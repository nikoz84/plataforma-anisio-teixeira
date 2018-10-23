
export default class Http {
    constructor(data = {}){
        this.endpoint = '/api-v1';
        this.data = data;
        
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

