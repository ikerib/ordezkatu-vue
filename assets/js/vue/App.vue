<template>
    <div>
        <Navbar :zerrendaName="zerrendaName"></Navbar>
        <hr>
        <ZerrendaList :employeeList="employeeList"></ZerrendaList>
    </div>

</template>

<script>
    import Navbar from './components/Navbar'
    import ZerrendaList from "./components/ZerrendaList";
    import axios from 'axios'

    export default {
        name: 'app',
        components: {
            ZerrendaList,
            Navbar
        },
        data() {
            return {
                zerrendaName: 'Kargatzen',
                employeeList:null
            }
        },
        mounted() {
            let el = document.querySelector("div[data-zerrenda]");
            let zerrenda = JSON.parse(el.dataset.zerrenda);
            this.zerrendaName = zerrenda.name;

            const urlZerrendaEmployee = Routing.generate("get_employeezerrenda", {'zerrendaid': zerrenda.id });
            axios
                .get(urlZerrendaEmployee)
                .then(response => {
                    this.employeeList = response.data;
                })
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
