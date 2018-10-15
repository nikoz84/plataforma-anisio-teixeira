
export default class Http {
    constructor(endPoint){
        this.url = '/api-v1/' + endPoint;
        this.data = null;
    }
    async getData(){
        try{
            return await axios.get(this.url);
        } catch (error){
            console.log(error)
        } 
        
    }
    async search(termo, limit, page){
        
        try {
            return await this.http.get(`${this.url}/search/termo/${termo}/limit/${limit}/page/${page}`);
        } catch (error)
        {
            //
        }
    }
    async postData(){
        try {
            return await axios.post(this.url);
            
        } catch (error) {
            console.error(error);
        }
    }
    async putData(){
        try {
            const response = await axios.put(this.url);
            return response.data;
        } catch (error) {
            console.error(error);
        }
    }
    async deleteData(){
        try {
            const response = await axios.delete(this.url);
            return response.data;
        } catch (error) {
            console.error(error);
        }
    }

}

