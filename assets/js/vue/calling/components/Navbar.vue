<template>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
        <div class="row container">
            <div class="col-md-4"><h5><strong>Eskeintza</strong>: {{ jobName }}</h5></div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <label for="filterByCallStatus">Filtratu</label>
                <select :value="filterCallStatus" @input="doFilterCallStatusChange" id="filterByCallStatus" class="custom-select">
                    <option value="-1">Guztiak</option>
                    <option value="0">Deitu gabe</option>
                    <option v-for="erantzuna in erantzunak" v-bind:value="erantzuna.id">{{erantzuna.name}}</option>
                </select>
            </div>
        </div>
<!--        <div class="col-md-10">-->
<!--            <h5>// </h5>-->
<!--        </div>-->
    </nav>
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
