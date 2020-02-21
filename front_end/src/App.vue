<template>
  <div id="app">
      <b-navbar toggleable="sm" v-if="loggedIn" type="light" variant="light">
          <b-navbar-brand>Concert Manager</b-navbar-brand>

          <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

          <b-collapse id="nav-collapse" is-nav>

              <b-navbar-nav class="ml-auto">
                  <b-nav-item to="/">Dashboard</b-nav-item>
                  <b-nav-item to="/myConcerts">My Concerts</b-nav-item>
                  <b-nav-item to="/aboutMe">About Me</b-nav-item>
                  <b-nav-item @click="logout">Logout</b-nav-item>
              </b-navbar-nav>

          </b-collapse>
      </b-navbar>
    <router-view id="routerView"/>
  </div>
</template>

<script>
  import {authComputed} from "./store/helpers";

  export default {
    computed: {
      ...authComputed
    },
    methods: {
      logout() {
        this.$store.dispatch('logout');
      }
    }
  }
</script>

<style scoped>
#app {
  /*font-family: Avenir, Helvetica, Arial, sans-serif;*/
  /*-webkit-font-smoothing: antialiased;*/
  /*-moz-osx-font-smoothing: grayscale;*/
  /*text-align: center;*/
  /*color: #2c3e50;*/
}
    #routerView {
        margin: 25px auto;
        width: 70%;
    }
</style>
