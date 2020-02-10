<template>
    <div>
        <p>Gehitu hautagaiak eskeintzarara:</p>
        <hr>
        <div class="form-group">
            <label for="cmbZerrendak">Zerrendak</label>
            <select :value="selectedZerrendaId" @input="changeZerrendaId" id="cmbZerrendak" class="custom-select">
                <option disabled value="-1">Aukeratu bat</option>
                <option v-for="zerrenda in zerrendak" v-bind:value="zerrenda.id">{{zerrenda.name}}</option>
            </select>
        </div>
        <div class="form-group">
            <label for="cmbTypes">Egoera mota</label>
            <select :value="selectedTypeId" @input="changeTypeId" id="cmbTypes" class="custom-select">
                <option disabled value="-1">Aukeratu bat</option>
                <option v-for="type in types" v-bind:value="type.id">{{type.name}}</option>
            </select>
        </div>
        <hr>
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>Pos</th>
                    <th>Izena</th>
                    <th>Abizenak</th>
                    <th>Telf</th>

                </tr>
            </thead>
            <tbody>
                <tr v-for="e in employeesList" v-bind:value="e.id">
                    <th>{{e.position}}</th>
                    <td>{{ e.employee.name}}</td>
                    <td>{{ e.employee.abizena1 }}&nbsp;{{ e.employee.abizena2 }}</td>
                    <td>{{ e.employee.telefono }}</td>

                </tr>
            </tbody>
        </table>
    </div>

</template>

<script>
    import axios from "axios";

    export default {
        name: 'app',
        data() {
            return {
                job: null,
                types: [],
                selectedTypeId: "-1",
                selectedZerrendaId: null,
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
                console.log("Change Zerrenda cmb:" + e.target.value);
                const url = Routing.generate("get_employeezerrenda", { "zerrendaid": e.target.value });
                console.log(url);
                axios.get(url).then(response => {
                    console.log("Response");
                    console.log(response);
                    console.log(response.data);
                    this.employees = (response.data)
                });
            }
        }
    }
</script>
