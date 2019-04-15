var axios = require("axios");

let auth = (localStorage.token) ? "Bearer " + localStorage.token : null;

var axiosInstance = axios.create({
  baseURL: "http://pat.des/api-v1",
  /* other custom settings */
  "X-Requested-With": "XMLHttpRequest",
  Authorization: auth
});

module.exports = axiosInstance;
