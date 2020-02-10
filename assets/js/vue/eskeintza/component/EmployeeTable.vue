<template>
    <div>
        <template v-if="useFor=='selection'">
            <p>Hauek dira zerrendako hautagaiak</p>
            <table class="table table-responsive">
                <thead>
                <tr>
                    <th></th>
                    <th>Pos</th>
                    <th>Izena</th>
                    <th>Abizenak</th>
                    <th>Telf</th>

                </tr>
                </thead>
                <tbody>
                <tr v-for="e in employeesList" v-bind:value="e.id">
                    <td>
                        <label for="checkbox"></label>
                        <input type="checkbox" id="checkbox" :value="selectEmployee" @input="changeEmployeeSelect(e.employee)">
                    </td>
                    <td>{{e.position}}</td>
                    <td>{{ e.employee.name}}</td>
                    <td>{{ e.employee.abizena1 }}&nbsp;{{ e.employee.abizena2 }}</td>
                    <td>{{ e.employee.telefono }}</td>

                </tr>

                </tbody>
            </table>
        </template>
        <template v-else>
            <p>Hauek dira aukeratuak izan diren hautagaiak:</p>
            <table class="table table-responsive">
                <thead>
                <tr>
                    <th></th>
                    <th>Izena</th>
                    <th>Abizenak</th>
                    <th>Telf</th>

                </tr>
                </thead>
                <tbody>
                <tr v-for="e in employeesList" v-bind:value="e.id">
                    <td>
                        <button class="btn btn-sm btn-danger" @input="removeFromSelectedEmployee(e)">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                    <td>{{ e.name}}</td>
                    <td>{{ e.abizena1 }}&nbsp;{{ e.abizena2 }}</td>
                    <td>{{ e.telefono }}</td>
                </tr>
                </tbody>
            </table>


        </template>


    </div>



</template>

<script>
    export default {
        name: "EmployeeTable",
        props: ["useFor"],
        data(){
            return {
                selectEmployee:null
            }
        },
        computed: {
            employeesList() {
                console.log("employeesList. userFor => " + this.useFor);
                if (this.useFor === "selection" ) {
                    console.log("EMPLOYEELIST");
                    return this.$store.getters.EMPLOYEELIST;
                } else {
                    console.log("SELECTEDEMPLOYEELIST");
                    return this.$store.getters.SELECTEDEMPLOYEELIST;
                }
            }
        },
        methods: {
            changeEmployeeSelect(e) {
                console.log("changeEmployeeSelect");
                console.log(e);
                // this.$store.commit("UPDATE_SELECTED_EMPLOYEELIST", e);
                this.$store.commit("SET_SELECTED_EMPLOYEELIST", e);
            },
            removeFromSelectedEmployee(e) {
                console.log('removeFromSelectedEmployee');
                console.log(e);
            }
        }

    };
</script>
