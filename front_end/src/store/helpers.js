import {mapGetters} from "vuex";

//This is used to allow other components of getter methods from store/index.js.. i think?
export const authComputed = {
    ...mapGetters(['loggedIn'])
};