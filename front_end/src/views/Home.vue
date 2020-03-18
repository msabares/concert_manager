<template>
    <div id="Home">

        <el-button @click="showModal=true">Show Modal</el-button>

        <concert-modal :show-modal="showModal" @close-modal="showModal=false"/>
    </div>
</template>

<script>
    import ConcertModal from "../components/ConcertModal";

    export default {
        name: "Home",
        components: {
            ConcertModal
        },
        data() {
            return {
                showModal: false
            }
        },
        methods: {
        }
    }
</script>

<style scoped>

</style>