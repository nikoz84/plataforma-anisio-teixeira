const axios = require("axios");

const auth = localStorage.token ? "Bearer " + localStorage.token : null;

const axiosInstance = axios.create({
  baseURL: "http://pat.des/api-v1",
  /* other custom settings */
  "X-Requested-With": "XMLHttpRequest",
  Authorization: auth
});

module.exports = axiosInstance;
