<template>
    <div id="myConcerts">
        <h1>Concerts</h1>
        <b-button @click="displayModal">Add Concert</b-button>
        <b-table :fields="fields" :items="getConcerts" show-empty striped responsive="sm">

            <template v-slot:cell(attended)="row">
                <b-icon-check-circle v-if="row.item.attended" variant="success" font-scale="1.5"></b-icon-check-circle>
            </template>

            <template v-slot:cell(openingActs)="row">
                <span v-for="item in row.item.openingActs" v-bind:key="item">
                    <i>{{item}}</i>
                </span>
            </template>

        </b-table>
        <ConcertModal :modal-id="modalID" />
    </div>
</template>

<script>
    import Axios from "axios";
    import ConcertModal from "../components/ConcertModal";
    import {authComputed} from "../store/helpers";

    export default {
        name: "MyConcertsPage",
        data() {
            return {
                fields: [
                    {
                        key: 'headliner',
                        label: 'Headliner',
                        sortable:true
                    },
                    {
                        key: 'openingActs',
                        label: 'Opening Acts',
                        sortable:true
                    },
                    {
                        key: 'date',
                        label: 'Date',
                        sortable:true
                    },
                    {
                        key: 'venue',
                        label: 'Venue',
                        sortable:true
                    },
                    {
                        key: 'attended',
                        label: 'Attended'
                    },
                ],
                modalID: "modalID"
            }
        },
        components: {
            ConcertModal
        },
        computed: {
            ...authComputed
        },
        methods: {
            getConcerts(ctx) {
                return Axios.request({
                    method: "GET",
                    url: 'http://localhost:8000/api/concerts?owner=' + this.jwtID,
                    headers: {'Accept': 'application/json'},
                    params: {searchFor:ctx.filter}
                })
                .then(response => {
                    return response.data;
                })
                .catch(errors => {
                    console.log(errors.response)
                })
            },
            displayModal: function () {
                // this.currentConcert = concert;
                this.$bvModal.show(this.modalID);
            },
        }
    }
</script>

<style scoped>
    #myConcerts {

    }
</style>