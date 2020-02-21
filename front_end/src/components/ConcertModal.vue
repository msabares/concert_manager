<template>
    <b-modal :id=modalId @shown="resetModal" :title="isNew ? 'Add Concert' : 'Edit Concert'">

        <b-form-group>
            <label>Headliner<span class="required"> *</span></label>
            <b-form-input required placeholder='"Indigo Joseph"' v-model="newConcert.headliner"></b-form-input>
        </b-form-group>

        <b-form-group>
            <label>Opening Act(s)</label>
            <b-form-tags placeholder='"League Of Wolves" "Megan Nash" ...' tag-variant="info" tag-pills v-model="newConcert.openingActs"></b-form-tags>
        </b-form-group>

        <b-form-group>
            <label>Venue<span class="required"> *</span></label>
            <b-form-input required placeholder='"Amigos Cantina"' v-model="newConcert.venue"></b-form-input>
        </b-form-group>

        <b-form-group>
            <label>Date<span class="required"> *</span></label>
            <b-form-datepicker required v-model="newConcert.date"></b-form-datepicker>
        </b-form-group>

        <b-form-checkbox v-model="newConcert.attended" size="lg" switch>Attended?</b-form-checkbox>

        <template v-slot:modal-footer>
            <b-button @click="$bvModal.hide(modalId)">Cancel</b-button>
            <b-button @click.stop="saveConcert">Save</b-button>
        </template>
    </b-modal>
</template>

<script>
    import Axios from "axios";
    import {authComputed} from "../store/helpers";

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

                this.newConcert.owner = "/api/users/" + this.jwtID;

                Axios.request({
                    method: this.newConcert.id === null ? 'POST' : 'PUT',
                    url: 'http://localhost:8000/api/concerts',
                    data: this.newConcert })
                .then( (response) => {
                    if(response.status === 201) {
                        this.$root.$emit('bv::refresh::table', 'concertTable');
                        this.$bvModal.hide(this.modalId)
                    }
                })
                .catch(error => {
                    console.log(error.response);
                })
            },
            resetModal: function () {
                Object.assign(this.newConcert, this.concert);
            }
        },
        computed: {
            ...authComputed,
            isNew: function () {
                return this.concert.id === null;
            }
        }
    }
</script>

<style scoped>
    .required {
        color: red;
    }
</style>