const client = require('axios');

export default {
  
  /**
   * Retorna dados do canal
   * @param {*} idCanal identificador do canal
   * @param {*} params parametros
   */
  async getDataFromIdCanal(params) {
    try {
      let id = localStorage.canal_id;
      let url = this.getUrlCanal(id);
      return await client.get(url, params);
    } catch (error) {
      return await error.response;
    }
  },
  /**
   * Retorna dados da url fornecida
   * @param {*} endPoint url do recurso
   * @param {*} params parametros
   */
  async getDataFromUrl(endPoint = "", params = {}) {
    try {
      return await client.get(endPoint, { params });
    } catch (error) {
      return await error.response;
    }
  },
  async getDataWithTokenUrl(endPoint = "", params) {
    try {
      return await client.get(endPoint, { params });
    } catch (error) {
      return await error.response;
    }
  },
  /**
   *
   * @param {*} method
   * @param {*} url
   * @param {*} data
   */
  async config(method, url, data) {
    return await client({
      method,
      url: url,
      params: data
    });
  },
  /**
   * Criar recurso
   * @param {*} endPoint url do recurso
   * @param {*} params parametros
   */
  async postData(endPoint = "", params = {}) {
    try {
      return await client.post(endPoint, params);
    } catch (error) {
      return await error.response;
    }
  },
  /**
   * Atualizar dados de um recurso
   * @param {*} endPoint url do recurso
   * @param {*} params parametros
   */
  async putData(endPoint = "", params = {}) {
    try {
      return await client.put(endPoint, { params });
    } catch (error) {
      return await error.response;
    }
  },
  /**
   * Apagar recurso
   * @param {*} endPoint url do recurso
   * @param {*} params parametros
   */
  async deleteData(endPoint = "", params = {}) {
    try {
      return await client.delete(endPoint, { params });
    } catch (error) {
      return await error.response;
    }
  },
  /**
   * Retorna a url do recurso segundo o canal
   * @param {*} id identificador unico do canal
   */
  getUrlCanal(id) {
    switch (true) {
      case id == 5:
        return `/conteudos/sites`;
        break;
      case id == 6:
        //console.warn('as')
        return `/conteudos`;
        break;
      case id == 9:
        return `/aplicativos`;
        break;
      default:
        return `/conteudos?canal=${id}&site=false`;
    }
  }
}
