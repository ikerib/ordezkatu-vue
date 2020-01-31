<template>
    <div>
        <Navbar :zerrendaName="zerrendaName"></Navbar>
        <hr>
        <ZerrendaList></ZerrendaList>
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
                zerrendaName: 'Kargatzen',
                employeezerrendaid: null
            }
        },
        mounted() {
            let el = document.querySelector("div[data-zerrenda]");
            let zerrenda = JSON.parse(el.dataset.zerrenda);
            this.zerrendaName = zerrenda.name;
            this.$store.dispatch("GET_EMPLOYEELIST", zerrenda.id);
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
