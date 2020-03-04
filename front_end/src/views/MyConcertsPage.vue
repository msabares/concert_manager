<template>
    <div id="myConcerts">
        <div id="header">
                <h1>Concerts</h1>
                <b-form-select class="w-25 mr-1 ml-2" v-model="searchByField" :options="selectFields"/>
                <b-input debounce="500" v-model="searchString" type="search" placeholder="Search concert"/>
                <b-button class="ml-2" variant="primary" size="sm" @click="displayModal(undefined)">
                    <b-icon-plus font-scale="1.8"/>
                </b-button>
        </div>
        <b-table id="concertTable"

                 :fields="fields"
                 :items="getConcerts"
                 :filter="searchString"
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

            <template v-slot:cell(buttonHolder)="row">
                <b-button @click.stop="displayModal(row.item)" size="sm" variant="light" class="mr-3">
                    <b-icon-pencil font-scale="1.5" variant="info"/>
                </b-button>
                <b-button @click.stop="deleteConcert(row.item.id)" size="sm" variant="light">
                    <b-icon-trash font-scale="1.5" variant="danger"/>
                </b-button>
            </template>

        </b-table>
        <ConcertModal :modal-id="modalID"  :concert="selectedConcert" />

    </div>
</template>

<script>
    import Axios from "axios";
    import ConcertModal from "../components/ConcertModal";
    import {authComputed} from "../store/helpers";

    const moment = require('moment');

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
                        key: 'venue',
                        label: 'Venue',
                        sortable:true
                    },
                    {
                        key: 'date',
                        label: 'Date',
                        sortable:true,
                        formatter: (value) => {
                            return moment(value).format("MMM D YYYY");
                        }
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
                items: [],
                selectedConcert: {
                    id: null,
                    headliner: null,
                    venue: null,
                    date: null,
                    attended: false,
                    openingActs: [],
                },
                searchString: '',
                selectFields: [
                    { value: 'headliner', text: 'Headliner'},
                    { value: 'openingActs', text: 'Opening Acts'},
                    { value: 'venue', text: 'Venue'},
                ],
                searchByField: 'headliner'
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
                let sorting = '';
                let params = new URLSearchParams();

                if(this.searchString) {
                    params.append(this.searchByField, this.searchString);
                }

                console.log(ctx);

                //The greasiest way to sort your table via API.
                if (ctx.sortBy) {
                    sorting = '&order['+ctx.sortBy+']='+ (ctx.sortDesc ? 'desc' : 'asc');
                }

                return Axios.request({
                    method: "GET",
                    url: 'http://localhost:8000/api/concerts?owner=' + this.jwtID + sorting,
                    headers: {'Accept': 'application/json'},
                    params: params
                })
                .then(response => {
                    return response.data;
                })
                .catch(errors => {
                    console.log(errors.response)
                })
            },
            displayModal (concert) {
                // this.currentConcert = concert;
                this.selectedConcert = concert;
                this.$bvModal.show(this.modalID);
            },
            deleteConcert(concertID) {
                Axios.request({
                    method: "DELETE",
                    url: 'http://localhost:8000/api/concerts/' + concertID,
                })
                .then( ()=> {
                    this.$root.$emit('bv::refresh::table', 'concertTable')
                })
                .catch(error => {
                    console.log(error.response)
                })
            }

        }
    }
</script>

<style scoped>
    #myConcerts {
        margin: 50px auto;
        width: 80%;
    }

    #header {
        display: flex;
        align-items: center;
    }

</style>