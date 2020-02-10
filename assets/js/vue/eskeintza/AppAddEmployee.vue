<template>
    <div>
        <p>Gehitu hautagaiak eskeintzarara:</p>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="cmbZerrendak">Zerrendak</label>
                    <select :value="selectedZerrendaId" @input="changeZerrendaId" id="cmbZerrendak" class="custom-select">
                        <option disabled value="-1">Aukeratu bat</option>
                        <option v-for="zerrenda in zerrendak" v-bind:value="zerrenda.id">{{zerrenda.name}}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="cmbTypes">Egoera mota</label>
                    <select :value="selectedTypeId" @input="changeTypeId" id="cmbTypes" class="custom-select">
                        <option disabled value="-1">Aukeratu bat</option>
                        <option v-for="type in types" v-bind:value="type.id">{{type.name}}</option>
                    </select>
                </div>
            </div>
        </div>


        <hr>
        <div class="row">
            <div class="col-md-6">
                <EmployeeTable :use-for="'selection'"></EmployeeTable>
            </div>
            <div class="col-md-6">
                <EmployeeTable :use-for="'selected'"></EmployeeTable>
            </div>
        </div>

    </div>

</template>

<script>
    import axios from "axios";
    import EmployeeTable from "./component/EmployeeTable";

    export default {
        name: 'app',
        components: {
            EmployeeTable
        },
        data() {
            return {
                job: null,
                types: [],
                selectedTypeId: "-1",
                selectEmployee: null,
                selectedZerrendaId: "-1",
                selectedZerrendaId: "-1",
                employeeList: [],
                zerrendak: [],
                employees: []
            }
        },
        mounted() {
            let el = document.querySelector("div[data-job]");
            this.job = JSON.parse(el.dataset.job);

            el = document.querySelector("div[data-types]");
            this.types = JSON.parse(el.dataset.types);

            el = document.querySelector("div[data-zerrendak]");
            this.zerrendak = JSON.parse(el.dataset.zerrendak);

        },
        computed: {
          employeesList() {

              return this.employees
          }
        },
        methods: {
            changeTypeId: function(e) {
                console.log("Change type cmb:" + e.target.value);
            },
            changeZerrendaId: function (e) {
                // console.log("Change Zerrenda cmb:" + e.target.value);
                // const url = Routing.generate("get_employeezerrenda", { "zerrendaid": e.target.value });
                // console.log(url);
                // axios.get(url).then(response => {
                //     console.log("Response");
                //     console.log(response);
                //     console.log(response.data);
                //     this.employees = (response.data)
                // });
                console.log('changeZerrendaId');
                this.$store.dispatch("GET_EMPLOYEELIST", e.target.value);
            },
            changeEmployeeSelect: function (e) {
                console.log("Employee select");
                console.log(e);
            }
        }
    }
</script>
