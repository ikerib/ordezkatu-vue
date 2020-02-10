<template>
    <div>
        <div v-for="(el, index) in employeeList">
            <div class="card border-light">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8 col-sm-8">
                            <ul class="list-inline no-bottom-marging">
                                <li class="list-inline-item">
                                    <button :id="'btnCollapse' + el.id" class="btn collapsed" type="button" data-toggle="collapse" v-bind:data-target="'#collapse' +el.id"
                                            aria-expanded="false" aria-controls="collapseExample">
                                    <span class="when-closed">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                        <span class="when-opened">
                                        <i class="fas fa-chevron-down"></i>
                                    </span>
                                    </button>
                                </li>
                                <li class="list-inline-item"><h5>Pos: <span class="badge badge-secondary">{{el.position}}</span></h5></li>
                                <li class="list-inline-item">&nbsp;</li>
                                <li class="list-inline-item"><h5>{{el.employee.name}} {{el.employee.abizena1}} {{el.employee.abizena2}}</h5></li>
                            </ul>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <ul class="list-inline no-bottom-marging text-right ">
                                <li class="list-inline-item">
                                    <button v-if="!isCalling[el.id]" @click="newCall(el)" class="btn btn-outline-secondary">
                                        <i class="fas fa-phone"> Dei berria</i>
                                    </button>
                                    <button v-if="isCalling[el.id]" @click="endCall" class="btn btn-warning">
                                        <i class="fas fa-phone"> Deia Amaitu</i>
                                    </button>
                                </li>
                                <li class="list-inline-item">
                                    <button :id="'btnCollapse' + el.id" class="btn collapsed" type="button" data-toggle="collapse" v-bind:data-target="'#collapse' +el.id"
                                            aria-expanded="false" aria-controls="collapseExample">
                                    <span class="when-closed">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                        <span class="when-opened">
                                        <i class="fas fa-chevron-down"></i>
                                    </span>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="collapse" v-bind:id="'collapse' +el.id">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-1">&nbsp;</div>
                            <div class="col-md-2">
                                <h5 class="card-title">Telf: {{ el.employee.telefono}}</h5>
                                <dl>
                                    <dt>email</dt>
                                    <dd>{{el.employee.email}}</dd>
                                    <dt>N.A.N.</dt>
                                    <dd>{{el.employee.nan}}</dd>
                                    <dt>Herria</dt>
                                    <dd><span v-if="el.employee.municipio">{{el.employee.municipio.name}}</span></dd>
                                    <dt>Probintzia</dt>
                                    <dd><span v-if="el.employee.municipio">{{el.employee.municipio.provincia}}</span></dd>
                                </dl>
                            </div>
                            <div class="col-md-1">&nbsp;</div>
                            <div class="col-md-8">
                                <CallTable :rowData="el.calls" :zerrendaid="zerrendaid" :employeeid="el.employee.id"></CallTable>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <stack-modal :show="show"
                         title="Nola amaitu da deia?"
                         @close="doModalClose"
                         v-on:save="doModalSave"
                         :modal-class="{ ['modal-morder-0']: true }"
                         :saveButton="{ title: 'Gorde', visible: true, btnClass: {'btn btn-primary': true}}"
                         :cancelButton="{ title: 'Ezeztatu', visible: true, btnClass: {'btn btn-outline-secondary': true}}"

            >
                <h5 class="modal-title"><span v-if="emp.employee">{{ emp.employee.name }} {{ emp.employee.abizena1 }} {{ emp.employee.abizena2 }}</span></h5>

                <div class="form-group">
                    <label for="cmdCallStatus"></label>
                    <select :value="valueCallStatus" @input="updateCallStatus" id="cmdCallStatus" class="custom-select">
                        <option disabled value="-1">Aukeratu bat</option>
                        <option v-for="type in types" v-bind:value="type.id">{{type.name}}</option>
                    </select>
                </div>
                <hr>
                <div class="form-group">
                    <label for="txtNotes"></label>
                    <textarea :value="notes" @input="updateNotes" name="notes" id="txtNotes" class="form-control" cols="30" rows="10"></textarea>
                </div>
            </stack-modal>
        </div>



    </div>
</template>

<script>
    import CallTable from "./CallTable";
    import StackModal from "@innologica/vue-stackable-modal";

    export default {
        name: "ZerrendaList",
        components: {
            CallTable,
            StackModal
        },
        props: ['zerrendaid'],
        data() {
            return {
                modalClass: "",
                types: [],
                emp: "",
                rowData: [],
                isCalling: []
            };
        },
        mounted() {
            let el = document.querySelector("div[data-types]");
            this.types = JSON.parse(el.dataset.types);
        },
        computed: {
            employeeList() {
                return this.$store.getters.EMPLOYEELIST;
            },
            lastId() {
                return this.$store.getters.CURRENT_CALL;
            },
            show() {
                return this.$store.getters.SHOW;
            },
            valueCallStatus: {
                get: function() {
                    return this.$store.getters.VALUE_CALL_STATUS;
                },
                set: function (value) {
                    this.$store.commit("SET_CALL_STATUS", value);
                }
            },
            notes() {
                return this.$store.getters.NOTES;
            }
        },
        methods: {
            updateNotes: function(e) {
                this.$store.commit("SET_NOTES", e.target.value);
            },
            updateCallStatus: function(e) {
                this.$store.commit("SET_CALL_STATUS", e.target.value);
            },
            newCall: function ( el ) {
                this.$set(this.isCalling, el.id, true);
                const cardBody = document.getElementById("collapse" + el.id);
                if ( !cardBody.classList.contains("show") ) {
                    const btnName = "btnCollapse" + el.id;
                    const btn = document.getElementById(btnName);
                    btn.click();
                }

                this.emp = el;
                const payload = {
                    zerrendaid: this.zerrendaid,
                    employeeid: el.employee.id
                };

                this.$store.dispatch('ADD_CALL', payload)

            },
            endCall: function ( el ) {
                this.$set(this.isCalling, el.id, false);
                const payload = {
                    valueCallStatus: this.valueCallStatus ? this.valueCallStatus : null,
                    notes: this.notes ? this.notes : null
                };
                this.$store.dispatch("TOOTGLE_SHOW", payload);
            },
            doModalSave: function () {
                console.log('doModalSave');
                console.log(this.valueCallStatus);

                if (( this.valueCallStatus ) && ( this.valueCallStatus !== "-1" )){
                    const payload = {
                        valueCallStatus: this.valueCallStatus,
                        notes: this.notes,
                        zerrendaid: this.zerrendaid,
                        id: this.lastId
                    };
                    this.$store.dispatch("UPDATE_CALL", payload);
                    this.isCalling = false;
                    this.valueCallStatus = "-1"
                }
                const myData = {
                    valueCallStatus: this.valueCallStatus ? this.valueCallStatus : null,
                    notes: this.notes ? this.notes : null
                };
                this.$store.dispatch("TOOTGLE_SHOW", myData);
            },
            doModalClose: function() {
                const payload = {
                    valueCallStatus: null,
                    notes: null
                };
                this.$store.dispatch("TOOTGLE_SHOW", payload);
            }
        }

    };
</script>

<style scoped>
    .collapsed > .when-opened,
    :not(.collapsed) > .when-closed {
        display: none;
    }
</style>
