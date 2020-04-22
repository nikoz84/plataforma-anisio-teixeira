import axios from "axios";
import { Notify, Dialog, Loading } from "quasar";
import router from "./router";
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
    let status = error.response.status;
    let message = error.response.data.message;
    let statusText = status ? message : "Erro desconhecido " + status;
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
        document.reload()
        break;
      case 403:
        // Não Permitido
        router.push("/");
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
        Notify.create({
          position: "top-right",
          color: "negative",
          message: statusText
        });
        break;
    }
    Loading.hide();
    let data = error.response.data;
    return Promise.reject(data);
  }
);
