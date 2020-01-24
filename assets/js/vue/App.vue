<template>
    <div>
        <Navbar :zerrendaName="zerrendaName"></Navbar>
        <hr>

    </div>

</template>

<script>
    import Navbar from './components/Navbar'
    import axios from 'axios'

    export default {
        name: 'app',
        components: {
            Navbar
        },
        data() {
            return {
                zerrendaName: 'Kargatzen'
            }
        },
        mounted() {
            let el = document.querySelector("div[data-zerrenda]");
            let zerrenda = JSON.parse(el.dataset.zerrenda);
            console.log(zerrenda);
            this.zerrendaName = zerrenda.name;
            console.log("url sortzen");
            const urlZerrendaEmployee = Routing.generate("get_zerrenda", {'id': zerrenda.id });
            console.log("url sortua, hau da:");
            console.log(urlZerrendaEmployee);

            axios
                .get(urlZerrendaEmployee)
                .then(response => {
                    console.log("Axios erantzuna:");
                    console.log(response);
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
