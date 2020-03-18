<template>
    <b-modal :id=modalId
             @hide="resetErrorMessages"
             @shown="resetModal"
             :title="isNew ? 'Add Concert' : 'Edit Concert'">

            <!--Headliner input field-->
            <b-form-group>
                <label>Headliner<span class="required"> *</span></label>
                <b-form-input
                        placeholder='"Indigo Joseph"'
                        :state="validateState('headliner')"
                        v-model="$v.newConcert.headliner.$model"/>
                <b-form-invalid-feedback>
                    This is a required field.
                </b-form-invalid-feedback>
            </b-form-group>

            <!--Opening Act(s) input field-->
            <b-form-group>
                <label>Opening Act(s)</label>
                <b-form-tags placeholder='"League Of Wolves" "Megan Nash" ...'
                             tag-variant="info"
                             tag-pills
                             v-model="newConcert.openingActs"/>
            </b-form-group>

            <!--Venue input field-->
            <b-form-group>
                <label>Venue<span class="required"> *</span></label>
<!--                <b-form-input placeholder='"Amigos Cantina"'-->
<!--                              :list="getVenueList"-->
<!--                              :state="validateState('venue')"-->
<!--                              v-model="$v.newConcert.venue.$model"/>-->
<!--                <b-form-invalid-feedback>-->
<!--                    This is a required field.-->
<!--                </b-form-invalid-feedback>-->
                    <b-form-input placeholder='"Amigos Cantina"'
                                  :list="getVenueList"
                                  :state="validateState('venue')"
                                  v-model="$v.newConcert.venue.$model"/>
                    <b-form-invalid-feedback>
                        This is a required field.
                    </b-form-invalid-feedback>

            </b-form-group>

            <!--Date input field-->
            <b-form-group>
                <label>Date<span class="required"> *</span></label>
                <b-form-input :state="validateState('date')"
                              type="date"
                              v-model="$v.newConcert.date.$model"/>
                <b-form-invalid-feedback>
                    This is a required field.
                </b-form-invalid-feedback>
            </b-form-group>

            <!--Attended Checkbox field-->
            <b-form-checkbox v-model="newConcert.attended" size="lg" switch>Attended?</b-form-checkbox>

            <!--Replacing the Modal footer with our own using v-slot-->
            <template v-slot:modal-footer="{cancel}">
                <div class="w-100">
                    <p class="float-left"><span class="required">* </span>Required Fields</p>
                    <b-button class="float-right ml-2" @click="saveConcert" variant="primary" >{{isNew ? 'Add' : 'Save'}}</b-button>
                    <b-button class="float-right" @click="cancel">Cancel</b-button>
                </div>
            </template>

    </b-modal>
</template>

<script>
    import Axios from "axios";
    import {authComputed} from "../store/helpers";
    import { required } from "vuelidate/lib/validators";

    export default {
        name: "ConcertModal",
        props: {
            concert: {
                type: Object,
                default: () => ({
                        id: null,
                        headliner: null,
                        venue: null,
                        date: null,
                        attended: false,
                        openingActs: [],
                    })
            },
            modalId: {
                type: String,
                default: 'modal'
            }
        },
        data() {
            return {
                //This makes a copy of the concert prop (a existing or new object)
                newConcert: Object.assign({}, this.concert),
                venueList: [] //All the Venues
            }
        },
        methods: {
            saveConcert() {
                this.$v.newConcert.$touch(); //Prompts the input fields for any errors.

                if(this.$v.newConcert.$anyError) return; //Exit the method if there are ant errors.

                //We're adding the IRI string into the newConcert object to set the ownership of the object.
                this.newConcert.owner = "/api/users/" + this.jwtID;

                //If the object we're making has no ID, we'll add a new concert in the database.
                //If the ID does exist, that means we're editing an exiting convert.
                let methodType, urlID;
                if(this.newConcert.id === null) {
                    methodType = "POST";
                } else {
                    methodType = "PUT";
                    urlID =  "/" + this.newConcert.id;
                }

                Axios.request({
                    method: methodType,
                    url: 'http://localhost:8000/api/concerts' + urlID,
                    data: this.newConcert
                })
                .then( () => {
                    this.$root.$emit('bv::refresh::table', 'concertTable');
                    this.$bvModal.hide(this.modalId);
                })
                .catch(error => {
                    console.log(error.response);
                })

            },
            getVenueList() {


                Axios.request( {
                    method: "GET",
                    url: 'http://localhost:8000/api/users/' + this.jwtID,
                    headers: {'Accept': 'application/json'}
                }).then(response => {
                    this.venueList = response.data['venueList']
                })
            },
            resetModal() {
                Object.assign(this.newConcert, this.concert);
                console.log(this.concert.date);
            },
            resetErrorMessages() {
                //Resets error messages
                this.$nextTick(() => {
                    this.$v.$reset();
                });
            },
            validateState(field) {
                const { $dirty, $error } = this.$v.newConcert[field];
                return $dirty ? !$error : null;
            }
        },
        computed: {
            ...authComputed,
            isNew: function () {
                return this.concert.id === null;
            }
        },
        validations: {
            newConcert: {
                headliner: { required },
                venue: { required },
                date: { required }
            }
        }
    }
</script>

<style scoped>
    .required {
        color: red;
    }
</style>