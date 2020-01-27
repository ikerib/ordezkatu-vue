<template>
    <div>
        <div v-for="el in employeeList">

            <div class="card border-light">
                <div class="card-header">
                    <ul class="list-inline no-bottom-marging">
                        <li class="list-inline-item">
                            <button class="btn" type="button" data-toggle="collapse" v-bind:data-target="'#collapse' +el.id" aria-expanded="false" aria-controls="collapseExample">
                                <i class="fas fa-chevron-right"></i>{{el.id}}
                            </button>
                        </li>
                        <li class="list-inline-item"><h5>Pos: <span class="badge badge-secondary">{{el.position}}</span></h5></li>
                        <li class="list-inline-item">&nbsp;</li>
                        <li class="list-inline-item"><h5>{{el.employee.name}} {{el.employee.abizena1}} {{el.employee.abizena2}}</h5></li>
                    </ul>

                </div>
                <div class="collapse" v-bind:id="'collapse' +el.id" >
                    <div class="card-body">
                        <h5 class="card-title">Special title treatment</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
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
        }
    };
</script>

