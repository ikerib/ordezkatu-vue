<template>
    <div>
        <Navbar :zerrendaName="zerrendaName"></Navbar>
        <hr>
    </div>

</template>

<script>
    import Navbar from './components/Navbar'

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
            this.zerrendaName = zerrenda.name;
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
