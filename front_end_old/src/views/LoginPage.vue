<template>
    <div id="login" @submit.prevent="login">
        <h1>Concert Manager</h1>
        <p>Track and manage all the concerts you've seen!</p>
        <div id="loginForm">
            <h2>Login</h2>
            <b-form >
                <b-form-group label="Email" >
                    <b-form-input
                            type="email"
                            required
                            v-model="email"
                    ></b-form-input>
                </b-form-group>
                <b-form-group label="Password" >
                    <b-form-input
                            type="password"
                            required
                            v-model="password"
                    ></b-form-input>
                </b-form-group>

                <b-button  type="submit" class="mb-3 text-right" variant="primary">Login</b-button>

                <b-alert fade :show="showError" variant="danger">
                    {{errors}}
                </b-alert>

                <p style="text-align: center" ><router-link to="/register">Don't have an account? Register.</router-link></p>

            </b-form>
        </div>

    </div>
</template>

<script>
    export default {
        name: "Login",
        data() {
            return {
                email: "",
                password: "",
                errors:'',
                showError: false
            }
        },
        methods: {
            login () {
                this.showError=false;
                this.$store.dispatch('login', {
                    email: this.email,
                    password: this.password
                })
                    .then(() => { this.$router.push({ name: 'Dashboard' }) })
                    .catch( error => {
                        this.errors = error.response.data.message;
                        this.showError=true;
                    })
            }
        }
    }
</script>

<style scoped>
    #login {
        margin: 50px auto;
        max-width: 500px;
    }

    #loginForm {
        margin-top: 30px;
    }
</style>