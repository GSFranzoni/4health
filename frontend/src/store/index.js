import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios';

// import example from './module-example'

Vue.use(Vuex)

/*
 * If not building with SSR mode, you can
 * directly export the Store instantiation;
 *
 * The function below can be async too; either use
 * async/await or return a Promise which resolves
 * with the Store instance.
 */

const Store = new Vuex.Store({
  state: {
    usuario: null,
    info: null
  },
  mutations: {
    setInfo(state, u) {
      state.info = u;
    },
    setUsuario(state, u) {
      state.usuario = u;
    },
    logout(state) {
      state.usuario = null;
      localStorage.removeItem('token');
      delete axios.defaults.headers.common["Authorization"];
    }
  },
  // enable strict mode (adds overhead!)
  // for dev mode only
  strict: process.env.DEV
})

export default Store;

