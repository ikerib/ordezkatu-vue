<template>
<!--    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">-->
        <div class="row navbar-light" style="background-color: #e3f2fd;">
            <div class="col-8"><h1>Eskeintza: {{ jobName }}</h1></div>
            <div class="col-4">

<!--                    <div class="form-group">-->

                        <label class="d-inline-block" for="filterByCallStatus">Filtratu</label>
                        <select :value="filterCallStatus" @input="doFilterCallStatusChange" id="filterByCallStatus" class="form-control custom-select d-inline-block">
                            <option value="-1">Guztiak</option>
                            <option value="0">Deitu gabe</option>
                            <option v-for="erantzuna in erantzunak" v-bind:value="erantzuna.id">{{erantzuna.name}}</option>
                        </select>

<!--                    </div>-->

            </div>
        </div>
</template>

<script>

    export default {

        name: 'Navbar',
        props: [
            "jobid",
            "jobName"
        ]
        ,
        data() {
            return {
                erantzunak: [],
                filterCallStatus: "-1"
            }
        },
        mounted() {
            let el = document.querySelector("div[data-erantzunak]");
            this.erantzunak = JSON.parse(el.dataset.erantzunak);
        },
        methods: {
            doFilterCallStatusChange(e) {
                if ( this.jobid != null ) {
                    this.$store.dispatch("GET_EMPLOYEELIST", this.jobid);
                    this.$store.commit("SET_FILTER_CALL_STATUS", e.target.value);
                    this.$store.dispatch("GET_EMPLOYEELIST", this.jobid);
                }
            }
        }
    }

</script>

<style scoped>
    select {
        padding-left:65px;
        height:40px;
        position:relative;
        border:1px solid #333;
        width:300px;
        display:block;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        -o-appearance: none;
        -ms-appearance: none;
        border-radius: 0;
        -webkit-box-shadow: none;
    }
    label {
        position:absolute;
        z-index:1;
        height:40px;
        line-height:40px;
        pointer-events:none;
        text-indent:10px;
        font-weight:bold;
    }
    label, select {
        font-family:Arial;
        font-size:15px;
    }
</style>
