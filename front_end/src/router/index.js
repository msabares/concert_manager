import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from '../views/Login.vue'
import Home from '../views/Home.vue'
import Register from "../views/Register";

Vue.use(VueRouter);

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: {alreadyAuth: true}
  },
  {
    path: '/register',
    name: 'Register',
    component: Register,
    meta: {alreadyAuth: true}
  },
  {
    path: '/',
    name: 'Home',
    component: Home,
    meta: {requiresAuth: true}
  }

];

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
});

router.beforeEach( (to, from, next) => {
  const loggedIn = localStorage.getItem('user');

  if(to.matched.some(record => record.meta.requiresAuth) && !loggedIn ) {
    //When a user goes to a page that requires authorization but they haven't logged in, they're
    //rerouted to /login page.
    next('/login');
  } else if (to.matched.some(record => record.meta.alreadyAuth) && loggedIn) {
    //When a user goes to pages a registration or login page, but they're already logged in,
    //they'll be rerouted to their home page.
    next('/')
  } else {
    next(); //continue to their desired page.
  }
});

export default router
