<template>
    <div id="register" @submit.prevent="createNewAccount">
        <h1>Register</h1>
        <b-form>
            <b-form-group label="Name" >
                <b-form-input
                        type="text"
                        v-model="name"
                ></b-form-input>
            </b-form-group>
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

            <b-button type="submit" class="mb-3" variant="primary">Create New Account</b-button>


            <p><router-link to="/">Already have an account? Login.</router-link></p>
        </b-form>

        <b-alert fade :show="showSuccess" variant="success">
            Account Created! You may now <router-link to="/">Login</router-link>.
        </b-alert>

    </div>
</template>

<script>
    export default {
        name: "Register",
        data() {
            return {
                name: "",
                email: "",
                password: "",
                showSuccess: false
            }
        },
        methods: {
            createNewAccount() {
                this.$store.dispatch('newAccount', {
                    name: this.name,
                    email: this.email,
                    password: this.password
                })
                    .then(() => {
                        this.showSuccess = true;
                    })
                    .catch( error => console.log(error.response))
            },
        }
    }
</script>

<style scoped>
    #register {
        margin: 50px auto;
        max-width: 500px;
    }

</style>