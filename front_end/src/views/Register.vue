<template>
    <el-container id="register" v-loading="loading">

        <!--Header-->
        <el-header>
            <h1 style="text-align: center">Concert Manager</h1>
        </el-header>

        <!--Body-->
        <el-main>
            <el-card shadow="hover" id="registerCard">
                <h1>Register</h1>

                <el-form :model="registerForm" :rules="rules" ref="registerForm" status-icon>

                    <!--Name Input-->
                    <el-form-item label="Name" prop="name">
                        <el-input v-model="registerForm.name"/>
                    </el-form-item>

                    <!--Email Input-->
                    <el-form-item label="Email" prop="email">
                        <el-input type="email" v-model="registerForm.email"/>
                    </el-form-item>

                    <!--Password Input-->
                    <el-form-item label="Password" prop="password">
                        <el-input type="password" v-model="registerForm.password"/>
                    </el-form-item>

                    <!--Confirm Password Input-->
                    <el-form-item label="Confirm Password" prop="confirmPassword">
                        <el-input type="password" v-model="registerForm.confirmPassword"/>
                    </el-form-item>

                    <!--Create or Reset Button-->
                    <el-form-item id="btnGroup">
                        <el-button type="primary" @click="createUser()">Create Account</el-button>
                        <el-button @click="resetForm()">Reset</el-button>
                    </el-form-item>

                    <!--Error Message-->
                    <transition name="el-zoom-in-top">
                        <el-alert v-show="showEmailError" :title="emailError" type="error" center show-icon/>
                    </transition>
                </el-form>
            </el-card>
        </el-main>

        <!--Footer-->
        <el-footer>
            <p style="text-align: center">
                <router-link style="text-decoration: none" to="/login">Already have an account? Login</router-link>
            </p>
        </el-footer>
    </el-container>
</template>

<script>
    export default {
        name: "Register",
        data() {
            let validateConfirmPassword = (rule, value, callback) => {
                if(value !==  this.registerForm.password) {
                    callback(new Error("Passwords don't match"))
                }
                callback();
            };
            return {
                loading: false,
                showEmailError: false,
                emailError: '',
                registerForm: {
                    name: '',
                    email: '',
                    password: '',
                    confirmPassword: ''
                },
                rules: {
                    name: [
                        {max: 255, message: 'Name must be less than 255 characters long', trigger: 'change'}
                    ],
                    email: [
                        {required: true, message: 'Please enter an Email Address', trigger: 'blur'},
                        {type: 'email', message: 'Please use a valid Email Address', trigger: 'blur'},
                        {max: 180, message: 'Email Address must be less than 180 characters long', trigger: 'change'}
                    ],
                    password: [
                        {required: true, message: 'Please enter a Password', trigger: 'blur'},
                        {min: 8, message: 'Password must be at least 8 characters long', trigger: 'blur'}
                    ],
                    confirmPassword:[
                        {required: true, message: 'Please enter a Password again', trigger: 'blur'},
                        {validator: validateConfirmPassword, trigger: 'blur'},
                    ]
                }
            }
        },
        methods: {
            createUser() {
                //This will check the rules and will prompt any error messages.
                this.$refs['registerForm'].validate( (valid) => {
                    if(valid) this.createAccount();
                })
            },
            resetForm() {
                this.$refs['registerForm'].resetFields();
            },
            createAccount() {
                this.loading = true;

                this.$store.dispatch('createAccount', {
                    name: this.registerForm.name,
                    email: this.registerForm.email.toLocaleLowerCase(),
                    password: this.registerForm.password
                }).then(()=> {

                }).catch((error) => {
                    //Hard coded an expect error for unique email violations.
                    //All other errors should be caught in the UI end.
                    this.emailError = error.response.data.violations[0].message;
                    this.showEmailError = true;
                }).finally( ()=> {
                    this.loading = false;
                })
            }
        }
    }
</script>

<style scoped>
    #registerCard {
        max-width: 500px;
        margin: 0 auto;
    }

    #btnGroup {
        margin-top: 30px
    }
</style>