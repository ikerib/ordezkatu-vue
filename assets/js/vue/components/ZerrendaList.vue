<template>
    <div>
        <div v-for="el in employeeList">

            <div class="card border-light">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10 col-sm-10">
                            <ul class="list-inline no-bottom-marging">
                                <li class="list-inline-item">
                                    <button class="btn collapsed" type="button" data-toggle="collapse" v-bind:data-target="'#collapse' +el.id" aria-expanded="false" aria-controls="collapseExample">
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
                                    <button @click="newCall" class="btn btn-outline-secondary" data-toggle="collapse" v-bind:data-target="'#collapse' +el.id">
                                        <i class="fas fa-phone"> Dei berria</i>
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
                                <table class="table  table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Noiz</th>
                                            <th>Eranztuna</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>01/01/2115</td>
                                            <td>Ez du hartzen</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>



                    </div>
                </div>
            </div>

        </div>


    </div>
</template>

<script>
    export default {
        name: "ZerrendaList",
        props: ['employeeList'],
        data() {
            return {

            }
        },
        methods: {
            newCall: function() {
                console.log("ring ring!");
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
