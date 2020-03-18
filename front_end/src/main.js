import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import './plugins/element.js'
import axios from 'axios'
import VueAxios from "vue-axios";

Vue.use(VueAxios, axios);

Vue.config.productionTip = false;


new Vue({
  router,
  store,
  created() {
    //When the browser is refreshed, the vue data won't make it over.
    //This will allow us to take the data in localStorage and 're-save' it into our vue data if
    //there's is data in localStorage.
    const userString  = localStorage.getItem('user');
    if(userString) {
      const userData = JSON.parse(userString);
      this.$store.commit('SET_USER_DATA', userData);
    }

    Vue.axios.interceptors.response.use(
        response => response,
        error => {
          if(error.response.status === 401 && localStorage.getItem('user') !== null) {
              //If a user uses an invalid token into their header, we'll log them out.
            this.$store.dispatch('logout');
          }
          return Promise.reject(error);
        }
    )
  },
  render: h => h(App)
}).$mount('#app');
