<template>
    <div>
        <pre>{{$data}}</pre>
    <table class="table  table-striped table-sm">
        <thead>
        <tr>
            <th>id</th>
            <th>Nork</th>
            <th>Noiz</th>
            <th>Erantzuna</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(r, index) in rowData" v-bind:index="index">
            <td>{{r.id}}</td>
            <td>{{r.user.username}}</td>
            <td>{{r.created | formatDate}}</td>
            <td><span v-if="r.result">{{r.result.name}}</span></td>
            <th>
                <ul class="list-inline">
                    <li><a href="#" @click="callRemove(r.id, index)"><i class="fas fa-trash-alt"></i></a></li>
                </ul>
            </th>
        </tr>
        </tbody>
    </table>
    </div>
</template>

<script>
    import store from '../store/store'
    export default {
        name: "CallTable",
        props: ['zerrendaid', 'employeeid'],
        computed: {
            rowData() {
                const payload = {
                    zerrendaid: this.zerrendaid,
                    employeeid: this.employeeid
                };
                return this.$store.getters.CALLS;
            }

        },
        methods: {
            callRemove: function (id, index) {
                if ( confirm("Seguru dei hau ezabatu nahi duzula?")) {
                    axios.delete('/api/calls/'+id)
                         .then(resp => {
                             this.rowData.splice(index, -1)
                         })
                         .catch(error => {
                             console.log(error);
                         })
                }
            }
        }
    }
</script>
