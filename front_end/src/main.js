import '@babel/polyfill'
import 'mutationobserver-shim'
import Vue from 'vue'
import './plugins/bootstrap-vue'
import App from './App.vue'
import router from './router'
import store from './store'
import Axios from "axios";
import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue'
import Vuelidate from 'vuelidate'

Vue.use(Vuelidate);
Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);

Vue.config.productionTip = false;
Vue.prototype.$http = Axios;

const token = localStorage.getItem('token');
if (token) {
  Vue.prototype.$http.defaults.headers.common['Authorization'] = token
}

new Vue({
  router,
  store,
  created() {
    const userString = localStorage.getItem('user');
    if (userString) {
      const userData = JSON.parse(userString);
      this.$store.commit('SET_USER_DATA', userData);
    }

    Axios.interceptors.response.use(
        response => response,
        error => {
          if (error.response.status === 401 && localStorage.getItem('user') !== null) {
              // Used for when someone adds a token to their header (like any token)
              // because it reloads, you won't be able to see invalid credentials errors.
              this.$store.dispatch('logout')
          }
          return Promise.reject(error);
        }
    )
  },
  render: h => h(App)
}).$mount('#app');
