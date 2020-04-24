import Quasar from "quasar";
import Vue from "vue";
import {
  Meta,
  Notify,
  Loading,
  Dialog,
  Dark,
  Platform,
  LocalStorage
} from "quasar";
import "quasar/dist/quasar.ie.polyfills.umd.min.js";
import lang from "quasar/lang/pt-br.js";
import iconSet from "quasar/dist/icon-set/material-icons.umd.min.js";
import "@quasar/extras/material-icons/material-icons.css";

Vue.use(Quasar, {
  lang,
  iconSet: iconSet,
  plugins: {
    Meta,
    Notify,
    Loading,
    Dialog,
    Dark,
    Platform,
    LocalStorage
  }
});

window.axios = require("axios");

window.axios.defaults.baseURL = process.env.MIX_API_URL; //process.env.MIX_API_URL;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

const jwtToken = localStorage.token;

window.axios.defaults.headers.common["Authorization"] = jwtToken ? `Bearer ${jwtToken}` : null;

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
  console.error(
    "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
  );
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key',
//     cluster: 'mt1',
//     encrypted: true
// });
