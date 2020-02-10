<template>
    <div>
        <Navbar :jobName="jobName" :zerrendaName="zerrendaName"></Navbar>
        <hr>
        <ZerrendaList :zerrendaid="zerrendaid"></ZerrendaList>
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
                zerrendaid: null,
                zerrendaName: 'Kargatzen',
                employeezerrendaid: null,
                jobName: 'Kargatzen'
            }
        },
        mounted() {
            let el = document.querySelector("div[data-zerrenda]");
            let job = JSON.parse(el.dataset.zerrenda);
            console.log(job);
            this.jobName = job.name;
            this.zerrendaName = job.zerrenda[0].name;
            this.zerrendaid = job.zerrenda[0].id;
            this.$store.dispatch("GET_EMPLOYEELIST", job.zerrenda[0].id);
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
