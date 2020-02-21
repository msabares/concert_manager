import Vue from 'vue'
import Vuex from 'vuex'
import Axios from "axios";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    userToken: null,

  },
  mutations: {
    SET_USER_DATA (state, userData) {
      state.userToken = userData;
      //console.log(state.user);
      localStorage.setItem('user', JSON.stringify(userData));
      Axios.defaults.headers.common['Authorization'] = 'Bearer ' + userData.token;
    },
    CLEAR_USER_DATA () {
      localStorage.removeItem('user');
      location.reload()
    }
  },
  actions: {
    // eslint-disable-next-line no-unused-vars
    newAccount({commit}, credentials) {
      return Axios.post('http://localhost:8000/api/users', credentials).then(
          // eslint-disable-next-line no-unused-vars
          ({data}) => {
            console.log("Credentials info: ", credentials);
            // commit('SET_USER_DATA', data)
          }
      )
    },

    login({commit}, credentials) {
      return Axios.post('http://localhost:8000/login', credentials).then(
          ({data}) => {
            //console.log("Response from server: ", data);
            commit('SET_USER_DATA', data);
          }
      )
    },
    logout({commit}) {
      commit('CLEAR_USER_DATA');
    }
  },
  getters: {
    loggedIn (state) {
      return !!state.userToken
    },
    jwt: state => JSON.stringify(state.userToken),
    jwtID (state, getters) {
      return state.userToken ? JSON.parse(atob(getters.jwt.split('.')[1])).id: null
    },
    jwtEmail (state, getters) {
      return state.userToken ? JSON.parse(atob(getters.jwt.split('.')[1])).username: null
    }
  },
  modules: {
  }
})
