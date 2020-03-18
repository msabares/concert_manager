import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

const urlAPI = 'http://localhost:8000';

export default new Vuex.Store({
  state: {
    userData: null,
  },
  mutations: {
    SET_USER_DATA(state, userData) {
      state.userData = userData; //Sets the token to our userToken state.
      localStorage.setItem('user', JSON.stringify(userData)); //Adds our token into the browser's localStorage.
      Vue.axios.defaults.headers.common['Authorization'] = 'Bearer ' + userData.token; //Add the token in every axios request
    },
    CLEAR_USER_DATA() { //Used to log the user out.
      localStorage.removeItem('user'); //Remove data from localStorage
      location.reload() //Reloading the webpage because data in our current vue session will be cleared?
    }
  },
  actions: {

    //Login will take the data from credentials param and post to the server to login.
    //Once we successfully loggin, we'll call the SET_USER_DATA mutation to save the data
    //we get from the server.
    login({commit}, credentials) {
      return Vue.axios.post(urlAPI + '/login', credentials)
          .then((data) => {
            commit('SET_USER_DATA', data);
          })
    },
    // eslint-disable-next-line no-unused-vars
    createAccount({commit}, userInfo){
      //return back the axios results in Register.vue
      return Vue.axios.post(urlAPI + '/api/users', userInfo)
    },
    //Logs out the user by remove localStorage data and reloading the browser
    logout({commit}) {
      commit('CLEAR_USER_DATA');
    }
  },
  getters: {
    //Checks our userdata state to see if our user is logged in.
    loggedIn(state) {
      return !!state.userData
    }
  },
  modules: {
  }
})
