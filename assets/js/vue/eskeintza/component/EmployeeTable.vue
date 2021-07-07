<template>
    <div>
        <template v-if="useFor=='selection'">
            <p>Hauek dira zerrendako hautagaiak</p>
            <table class="table">
                <thead>
                <tr>
                    <th><input type="checkbox" @click="doCheckAll"></th>
                    <th>Pos</th>
                    <th>Izena</th>
                    <th>Abizenak</th>
                    <th>Telf</th>
                    <th>Egoera</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(e, index) in employeesList" v-bind:value="e.id">
                    <td  :data-jobdetailid="e.id">
                        <label for="checkbox"></label>
                        <input type="checkbox"
                               id="checkbox"
                               :value="e.employee.id"
                               @input="changeEmployeeSelect(e, index)"
                               :checked="isChecked(e.employee)"
                        >
                    </td>
                    <td>{{ e.position }}</td>
                    <td>{{ e.employee.name }}</td>
                    <td>{{ e.employee.abizena1 }}&nbsp;{{ e.employee.abizena2 }}</td>
                    <td>{{ e.employee.telefono }}</td>
                    <td>{{e.type.name}}</td>
                </tr>
                </tbody>
            </table>
        </template>
        <template v-else>
            <p>Hauek dira aukeratuak izan diren hautagaiak:</p>
            <table class="table selectedEmployeesTable">
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
                <tr v-for="(e, index) in employeesList" v-bind:value="e.id">
                    <td>
                        <button class="btn btn-sm btn-danger" @click="removeFromSelectedEmployee(e)">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                    <td>
                        <div class="col-xs-1">
                            <label>
                                <input type="number" class="myWidth" :value="e.position" @change="doChangePosition(e, $event.target.value)">
                            </label>
                        </div>
                    </td>
                    <td>{{ e.employee.name}}</td>
                    <td>{{ e.employee.abizena1 }}&nbsp;{{ e.employee.abizena2 }}</td>
                    <td>{{ e.employee.telefono }}</td>
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
                if (this.useFor === "selection" ) {
                    console.log("NIRE DATUAK");
                    console.log(this.$store.getters.GET_EMPLOYEELIST);
                    return this.$store.getters.GET_EMPLOYEELIST;
                } else {
                    return this.$store.getters.GET_SELECTEDEMPLOYEELIST;
                }
            }
        },
        methods: {
            changeEmployeeSelect(e, index) {
                const payload = {
                    employee: e.employee,
                    position: e.position?e.position:null,
                    id: e.id
                };
                this.$store.dispatch("ACTION_ADD_REMOVE_EMPLOYEE_TO_LIST", payload);
            },
            removeFromSelectedEmployee(e) {
                this.$store.dispatch("ACTION_REMOVE_EMPLOYEE_FROM_LIST", e);
            },
            isChecked(e) {
                return this.$store.getters.GET_IS_SELECTED(e);
            },
            doCheckAll() {
                this.$store.dispatch("ACTION_DO_CHECK_ALL");
            },
            doChangePosition(e, position) {
                const payload = {
                    jobdetail: e,
                    position: position

                };
                this.$store.dispatch("ACTION_DO_CHANGE_POSITION", payload);
            }
        }
    };
</script>

<style scoped>
    .selectedEmployeesTable {
        background-color: gainsboro !important;
    }
    .myWidth {
        width: 60px;
    }
</style>
