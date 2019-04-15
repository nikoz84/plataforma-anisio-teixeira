var axios = require('axios');

let auth = (localStorage.token) ? "Bearer " + localStorage.token : null;

var axiosInstance = axios.create({
  baseURL: 'http://laravel.pat/api-v1',
  /* other custom settings */
  "X-Requested-With": "XMLHttpRequest",
  "Authorization": auth,
});


module.exports = axiosInstance;