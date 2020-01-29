<template>
    <div>
        <div v-for="el in employeeList">
            <div class="card border-light">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10 col-sm-10">
                            <ul class="list-inline no-bottom-marging">
                                <li class="list-inline-item">
                                    <button :id="'btnCollapse' + el.id" class="btn collapsed" type="button" data-toggle="collapse" v-bind:data-target="'#collapse' +el.id" aria-expanded="false" aria-controls="collapseExample">
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
                        <div class="col-md-2 col-sm-2">
                            <ul class="list-inline no-bottom-marging text-right ">
                                <li class="list-inline-item">
                                    <button v-if="!isCalling[el.id]" @click="newCall(el)" class="btn btn-outline-secondary">
                                        <i class="fas fa-phone"> Dei berria</i>
                                    </button>
                                    <button v-if="isCalling[el.id]" @click="endCall(el)" class="btn btn-warning">
                                        <i class="fas fa-phone"> Deia Amaitu</i>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="collapse" v-bind:id="'collapse' +el.id" >
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
                                <CallTable></CallTable>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>

        <stack-modal :show="show"
                     title="Nola amaitu da deia?"
                     @close="show=false"
                     v-on:save="doModalSave"
                     :modal-class="{ ['modal-morder-0']: true }"
                     :saveButton="{ title: 'Gorde', visible: true, btnClass: {'btn btn-primary': true}}"
                     :cancelButton="{ title: 'Ezeztatu', visible: true, btnClass: {'btn btn-outline-secondary': true}}"

        >
            <h5 class="modal-title"><span v-if="emp.employee">{{ emp.employee.name }} {{ emp.employee.abizena1 }} {{ emp.employee.abizena2 }}</span></h5>

            <label for="cmdCallStatus"></label>
            <select v-model="valueCallStatus" id="cmdCallStatus" class="custom-select">
                <option disabled value="">Aukeratu bat</option>
                <option v-for="type in types" v-bind:value="type.id">{{type.name}}</option>
            </select>

        </stack-modal>

    </div>
</template>

<script>
    import CallTable from "./CallTable";
    import StackModal from '@innologica/vue-stackable-modal'
    import axios from 'axios'
    export default {
        name: "ZerrendaList",
        components: {
            CallTable,
            StackModal
        },
        props: ['employeeList'],
        data() {
            return {
                show: false,
                modalClass: '',
                isCalling : [],
                types: [],
                valueCallStatus: '',
                emp: '',
                showModal: false
            }
        },
        mounted() {
            let el = document.querySelector("div[data-types]");
            this.types = JSON.parse(el.dataset.types);
        },
        methods: {
            newCall: function(el) {
                this.$set(this.isCalling, el.id, true);

                // check if card-cody is expanded or collapsed
                const cardBody = document.getElementById("collapse" + el.id);
                if ( !cardBody.classList.contains('show') ) {
                    const btnName = "btnCollapse" + el.id;
                    const btn = document.getElementById(btnName);
                    btn.click()
                }

                this.emp = el;

                axios.post()

            },
            endCall: function ( el ) {
                this.$set(this.isCalling, el.id, false);
                this.show = true
            },
            doModalSave: function (e) {

            }
        }

    };
</script>

<style scoped >
    .collapsed > .when-opened,
    :not(.collapsed) > .when-closed {
        display: none;
    }
</style>
