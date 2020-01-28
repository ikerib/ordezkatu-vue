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
                                    <button v-if="!isCalling[el.id]" @click="newCall(el.id)" class="btn btn-outline-secondary">
                                        <i class="fas fa-phone"> Dei berria</i>
                                    </button>
                                    <button v-if="isCalling[el.id]" @click="endCall(el.id)" class="btn btn-warning">
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


    </div>
</template>

<script>
    import CallTable from "./CallTable";
    export default {
        name: "ZerrendaList",
        components: {
            CallTable
        },
        props: ['employeeList'],
        data() {
            return {
                isCalling : []
            }
        },
        methods: {
            newCall: function(id) {
                this.$set(this.isCalling, id, true);

                // check if card-cody is expanded or collapsed
                const cardBody = document.getElementById("collapse" + id);
                if ( !cardBody.classList.contains('show') ) {
                    const btnName = "btnCollapse" + id;
                    const el = document.getElementById(btnName);
                    el.click()
                }
            },
            endCall: function ( id ) {

                this.$set(this.isCalling, id, false);
                console.log("hang up!");
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
