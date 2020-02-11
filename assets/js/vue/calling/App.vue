<template>
    <div>
        <Navbar :jobName="jobName"></Navbar>
        <hr>
        <ZerrendaList :jobid="this.jobid"></ZerrendaList>
    </div>

</template>

<script>
    import Navbar from './components/Navbar'
    import ZerrendaList from "./components/ZerrendaList";

    export default {
        name: 'app',
        components: {
            ZerrendaList,
            Navbar
        },
        data() {
            return {
                jobid: null,
                jobName: 'Kargatzen'
            }
        },
        mounted() {
            let el = document.querySelector("div[data-job]");
            const job = JSON.parse(el.dataset.job);
            console.log(job);
            this.jobid = job.id;
            this.jobName = job.name;

            this.$store.dispatch("GET_EMPLOYEELIST", job.id);
        }

    }
</script>

<style>
    #app {
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #2c3e50;
        margin-top: 60px;
    }
    .center {
        Text-align: center;
    }
</style>
