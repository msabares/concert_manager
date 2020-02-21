<template>
    <b-modal id="modalID" >

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


    </b-modal>
</template>s

<script>
    export default {
        name: "ConcertModal",
        props: {
            concert: {
                type: Object,
                default: () => ({id: null, headliner: null, venue: null, date: null, attended: null, openingActs: []})

            },
            modalId: {
                type: String,
                default: 'modal'
            }
        },
        data() {
            return {
                newConcert: Object.assign({}, this.concert),
            }
        }
    }
</script>

<style scoped>
    .required {
        color: red;
    }
</style>