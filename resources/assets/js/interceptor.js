import axios from "axios";
import { Notify, Dialog, Loading } from "quasar";
import router from "./routes";
import store from "./store";

axios.interceptors.response.use(
  response => {
    let message = response.data.message;
    if (message) {
      Notify.create({ position: "top-right", color: "positive", message });
    }

    return response;
  },
  function(error) {
    
    const status = error.response && error.response.status ? error.response.status : '';
    const message = error.response && error.response.data.message ? error.response.data.message : '';
    const statusText = status ? message : "Erro desconhecido " + status;
    switch (status) {
      case 404:
        // Não encontrado
        Notify.create({ position: "top-right", color: "accent", message });
        break;
      case 401:
        // Token Expirado
        Notify.create({ position: "top-right", color: "accent", message });
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        store.commit('SET_LOGOUT_USER');
        location.reload('/');
        break;
      case 403:
        // Não Permitido
        Notify.create({ position: "top-right", color: "accent", message });
        break;
      case 422:
        // Entidade não processada - não salva ou com outro problema
        Notify.create({ position: "top-right", color: "info", message });
        break;
      case 429:
        // Muitas requisições
        Notify.create({ position: "top-right", color: "negative", message });
        break;
      default:
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        store.commit('SET_LOGOUT_USER');
        location.reload('/');
        Notify.create({
          position: "top-right",
          color: "negative",
          message: statusText
        });
        break;
    }
    Loading.hide();
    let data = error && error.response ? error.response.data : {
      message : 'Erro indefinido',
      status: 500
    };
    return Promise.reject(data);
  }
);
