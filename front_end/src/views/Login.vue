<template>
  <el-container id="Login" v-loading="loading">

    <!--Header-->
    <el-header>
      <h1 style="text-align: center">Concert Manager</h1>
    </el-header>

    <!--Body-->
    <el-main>

      <el-card shadow="hover" id="loginCard">
        <h1>Login</h1>

        <el-form :model="loginForm" :rules="rules" ref="loginForm">

          <!--Email Input-->
          <el-form-item label="Email" prop="email">
            <el-input type="email" v-model="loginForm.email" prefix-icon="el-icon-message" clearable/>
          </el-form-item>

          <!--Password Input-->
          <el-form-item label="Password" prop="password">
            <el-input type="password" v-model="loginForm.password" prefix-icon="el-icon-more" clearable/>
          </el-form-item>

          <!--Login Button-->
          <el-form-item id="btnGroup">
            <el-button type="primary" @click="submitLogin">Login</el-button>
          </el-form-item>

          <!--Error Message-->
          <transition name="el-zoom-in-top">
            <el-alert v-show="showError" title="Invalid Email and/or Password" type="error" center show-icon/>
          </transition>

        </el-form>

      </el-card>

    </el-main>

    <!--Footer-->
    <el-footer>
      <p style="text-align: center">
        <router-link style="text-decoration: none" to="/register">Don't have an account? Register</router-link>
      </p>
    </el-footer>

  </el-container>
</template>

<script>
export default {
  name: 'Login',
  data() {
    return {
      loading: false,
      showError: false,
      loginForm: {
        email: '',
        password: ''
      },
      //Validation rules
      rules: {
        email: [
          {required: true, message: 'Please enter your Email Address', trigger: 'blur'}
        ],
        password: [
          {required: true, message: 'Please enter your Password', trigger: 'blur'}
        ]
      }
    }
  },
  methods: {
    submitLogin() {
      //This will check the rules and will prompt any error messages.
      this.$refs['loginForm'].validate( (valid) => {

        //If any rules weren't broken, we'll call our login method.
        if(valid) this.login();

      })
    },

    //Login() will call a method from the store/index.js and passing email and password to log the user in.
    login() {
      this.loading = true;

      this.$store.dispatch('login', {
        email: this.loginForm.email.toLocaleLowerCase(),
        password: this.loginForm.password
      }).then(() => {
        this.$router.push({ name: 'Home' })
      }).catch( ()=> {
        this.showError = true;
        this.$refs['loginForm'].resetFields();
      }).finally(() => {this.loading = false})
    }
  }
}
</script>

<style scoped>
  #loginCard {
    max-width: 500px;
    margin: 0 auto;
  }

  #btnGroup {
    margin-top: 30px
  }
</style>
