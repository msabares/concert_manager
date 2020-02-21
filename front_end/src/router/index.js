import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from "../views/LoginPage"
import DashboardPage from "../views/DashboardPage"
import RegistrationPage from "../views/RegistrationPage"
import AboutMePage from "../views/AboutMePage"
import MyConcertsPage from "../views/MyConcertsPage"

Vue.use(VueRouter);

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/register',
    name: 'Register',
    component: RegistrationPage
  },
  {
    path: '/',
    name: 'Dashboard',
    component: DashboardPage,
    meta: {requiresAuth: true}
  },
  {
    path: '/aboutMe',
    name: 'About Me',
    component: AboutMePage,
    meta: {requiresAuth: true}
  },
  {
    path: '/myConcerts',
    name: 'My Concerts',
    component: MyConcertsPage,
    meta: {requiresAuth: true}
  }

];

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
});

router.beforeEach((to, from, next) => {
  const loggedIn = localStorage.getItem('user');

  if(to.matched.some(record => record.meta.requiresAuth) && !loggedIn) {
    next('/login');
  } else {
    next();
  }
});

export default router
