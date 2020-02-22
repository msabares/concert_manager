<template>
    <b-modal :id=modalId
             @hide="resetErrorMessages"
             @shown="resetModal"
             :title="isNew ? 'Add Concert' : 'Edit Concert'">

            <b-form-group>
                <label>Headliner<span class="required"> *</span></label>
                <b-form-input
                        placeholder='"Indigo Joseph"'
                        :state="validateState('headliner')"
                        v-model="$v.newConcert.headliner.$model"></b-form-input>
                <b-form-invalid-feedback>
                    This is a required field.
                </b-form-invalid-feedback>
            </b-form-group>

            <b-form-group>
                <label>Opening Act(s)</label>
                <b-form-tags placeholder='"League Of Wolves" "Megan Nash" ...'
                             tag-variant="info"
                             tag-pills
                             v-model="newConcert.openingActs"></b-form-tags>
            </b-form-group>

            <b-form-group>
                <label>Venue<span class="required"> *</span></label>
                <b-form-input placeholder='"Amigos Cantina"'
                              :state="validateState('venue')"
                              v-model="$v.newConcert.venue.$model"></b-form-input>
                <b-form-invalid-feedback>
                    This is a required field.
                </b-form-invalid-feedback>
            </b-form-group>

            <b-form-group>
                <label>Date<span class="required"> *</span></label>
                <b-form-datepicker :state="validateState('date')"
                                   v-model="$v.newConcert.date.$model"></b-form-datepicker>
                <b-form-invalid-feedback>
                    This is a required field.
                </b-form-invalid-feedback>
            </b-form-group>

            <b-form-checkbox v-model="newConcert.attended" size="lg" switch>Attended?</b-form-checkbox>


        <template v-slot:modal-footer="{cancel}">
            <div class="w-100">
                <p class="float-left"><span class="required">* </span>Required Fields</p>
                <b-button class="float-right ml-2" @click="saveConcert" variant="primary" >Save</b-button>
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
            }
        },
        methods: {
            saveConcert() {
                this.$v.newConcert.$touch();

                //Exit the method if there are ant errors.
                if(this.$v.newConcert.$anyError) {
                    return;
                }

                this.newConcert.owner = "/api/users/" + this.jwtID;
                let methodType = '';
                let urlID = '';

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
            resetModal() {
                //Object.assign(this.concert, this.newConcert);
                Object.assign(this.newConcert, this.concert);
            },
            resetErrorMessages() {
                //Resets the states?
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