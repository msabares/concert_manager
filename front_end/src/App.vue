<template>
  <div id="app">

    <!--Nav Bar-->
    <el-menu v-if="loggedIn" default-active="1" mode="horizontal" background-color="#2E4057" text-color="white" active-text-color="#F4D35E">
      <el-menu-item>Home</el-menu-item>
      <el-menu-item @click="logout">Logout</el-menu-item>
    </el-menu>

    <!--Displays the current vue component-->
    <div id="currentPage">
      <router-view/>
    </div>

  </div>
</template>

<script>
  import {authComputed} from "./store/helpers";

export default {
  name: 'app',
  components: {

  },
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

<style>
#app {
  font-family: "Helvetica Neue",Helvetica,"PingFang SC","Hiragino Sans GB","Microsoft YaHei",Arial,sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  /*text-align: center;*/
  /*color: #2c3e50;*/
  /*margin-top: 60px;*/
}
</style>
