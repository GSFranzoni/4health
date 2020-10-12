import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios';


Vue.use(Vuex)

const Store = new Vuex.Store({
  state: {
    usuario: null,
    info: null,
    solicitacao: null
  },
  mutations: {
    setInfo(state, u) {
      state.info = u;
    },
    setUsuario(state, u) {
      state.usuario = u;
    },
    setSolicitacao(state, u) {
      state.solicitacao = u;
    },
    logout(state) {
      state.usuario = null;
      localStorage.removeItem('token');
      delete axios.defaults.headers.common["Authorization"];
    }
  },
  strict: process.env.DEV
})

export default Store;

