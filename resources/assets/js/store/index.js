import Vue from "vue";
import Vuex from "vuex";
import state from "./state.js";
import mutations from "./mutations.js";
import actions from "./actions.js";
import getters from "./getters.js";

Vue.use(Vuex);

const store = new Vuex.Store({
  state,
  getters,
  mutations,
  actions,
  modules: {
    //
  }
});

export default store;
