<template>
    <div id="myConcerts">
        <h1>Concerts</h1>
        <b-button @click="displayModal">Add Concert</b-button>
        <b-table id="concertTable"

                 :fields="fields"
                 :items="getConcerts"
                 show-empty
                 striped>

            <template v-slot:cell(attended)="row">
                <b-icon-check-circle v-if="row.item.attended" variant="success" font-scale="1.5"></b-icon-check-circle>
            </template>

            <template v-slot:cell(openingActs)="row">
                <span v-for="item in row.item.openingActs" v-bind:key="item">
                    <span> • {{item}} </span>
                </span>
            </template>

            <template v-slot:cell(buttonHolder)>
                <b-button size="sm" variant="light" class="mr-3">
                    <b-icon-pencil font-scale="1.5" variant="info"/>
                </b-button>
                <b-button size="sm" variant="light">
                    <b-icon-trash font-scale="1.5" variant="danger"/>
                </b-button>
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
                        label: 'Attended',
                        sortable:true
                    },
                    {
                        key: 'buttonHolder',
                        label:'Edit | Delete'
                    }
                ],
                modalID: "modalID",
                items: []
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
                let params = '';

                //The greasiest way to sort your table via API.
                if (ctx.sortBy) {
                    params = '&order['+ctx.sortBy+']='+ (ctx.sortDesc ? 'desc' : 'asc');
                }
                console.log(params);

                return Axios.request({
                    method: "GET",
                    url: 'http://localhost:8000/api/concerts?owner=' + this.jwtID + params,
                    headers: {'Accept': 'application/json'},
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
        margin: 50px auto;
        width: 80%;
    }
</style>