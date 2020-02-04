import axios from "axios";
import { Notify, Dialog, Loading } from "quasar";

axios.interceptors.response.use(
  response => response,
  function(error) {
    let status = error.response.status;
    let message = error.response.data.message;
    let statusText = "Erro desconhecido " + status;
    switch (status) {
      case 404:
        // Não encontrado
        Notify.create({ position: "top-right", color: "accent", message });
        break;
      case 401:
        // Token Expirado
        Notify.create({ position: "top-right", color: "accent", message });
        break;
      case 403:
        // Não Permitido
        Notify.create({ position: "center", color: "accent", message });
        break;
      case 422:
        // Entidade não processada - não salva ou com outro problema
        Notify.create({ position: "center", color: "info", message });
        break;
      case 429:
        // Muitas requisições
        Notify.create({ position: "center", color: "negative", message });
        break;
      default:
        Notify.create({
          position: "center",
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
