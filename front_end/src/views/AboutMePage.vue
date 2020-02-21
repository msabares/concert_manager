<template>
    <div id="aboutMe">
        <h3>Account Info</h3>
        <p>Name:  <b-form-input size="sm" v-model="user.name" :disabled=!editMode></b-form-input></p>
        <p>Email:  <b-form-input size="sm" v-model="user.email" :disabled=!editMode></b-form-input></p>
        <p>Favorite Color:  <b-form-input size="sm" v-model="user.favColor" :disabled=!editMode></b-form-input></p>
        <b-button v-if="!editMode" @click="edit">Edit</b-button>

        <b-button class="mr-3"
                  v-if="editMode"
                  :disabled=saving
                  @click="save">Save</b-button>

        <b-button v-if="editMode" debounce="500" @click="edit">Cancel</b-button>

    </div>
</template>

<script>
    import Axios from "axios";
    import {authComputed} from "../store/helpers";
    import _ from 'lodash'

    export default {
        name: "AboutMe",
        data() {
            return {
                user: {
                    name:'',
                    email:'',
                    favColor: ''
                },
                editMode: false,
                saving: false,
            }
        },
        computed: {
            ...authComputed
        },
        methods: {
            getUserInfo() {
                Axios.request({
                    method: "GET",
                    url: 'http://localhost:8000/api/users/' + this.jwtID,
                    headers: {'Accept': 'application/json'}
                })
                .then(response => {
                    this.user = {
                        name: response.data['name'],
                        email: response.data['email'],
                        favColor: response.data['favColor']
                    };
                })
            },
            edit() {
                this.editMode = !this.editMode;
            },
            save: _.debounce( function () {
                this.saving = true;
                Axios.request({
                    method:"PUT",
                    url: 'http://localhost:8000/api/users/' + this.jwtID,
                    data: this.user
                }).catch(error => {
                    console.log(error.response);
                })
                .finally(() => {
                    this.editMode = !this.editMode;
                    this.saving = false;
                });

            }, 500),
        },
        mounted() {
            this.getUserInfo();
        }
    }
</script>

<style scoped>
    #aboutMe {
        text-align: left;
        margin: 50px auto;
        max-width: 500px;
    }
</style>