<template>
    <div id="dashboard">
        <h1>Welcome!</h1>
    </div>
</template>

<script>

    import {authComputed} from "../store/helpers";

    export default {
        name: "DashboardPage",
        computed: {
            ...authComputed,
        },
        components: {
        },
        methods: {

        }
    }
</script>

<style scoped>
    #dashboard {
    }
</style>