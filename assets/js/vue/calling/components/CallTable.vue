<template>
    <table class="table  table-striped table-sm">
        <thead>
        <tr>
            <th>id</th>
            <th>Nork</th>
            <th>Noiz</th>
            <th>Erantzuna</th>
            <th>Oharrak</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(r, index) in rowData" v-bind:index="index">
            <td>{{r.id}}</td>
            <td>{{r.user.username}}</td>
            <td>{{r.created | formatDate}}</td>
            <td><span v-if="r.result">{{r.result.name}}</span></td>
            <td>{{r.notes}}</td>
            <th>
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="#" @click="callRemove(r.id, index)"><i class="fas fa-trash-alt"></i></a></li>
                    <li class="list-inline-item"><a href="#" @click="callEdit(r, index)"><i class="fas fa-edit"></i></a></li>
                </ul>
            </th>
        </tr>
        </tbody>
    </table>

</template>

<script>
    import store from '../store/store'
    export default {
        name: "CallTable",
        props: ['rowData','jobid', 'employeeid'],
           methods: {
            callRemove: function (id, index) {
                if ( confirm("Seguru dei hau ezabatu nahi duzula?")) {

                    const payload = {
                        callid: id,
                        jobid: this.jobid
                    };

                    this.$store.dispatch('REMOVE_CALL', payload)

                }
            },
            callEdit: function (call, index) {
                console.log('callEdit: ' +  call.id);
                console.log(call);
                const payload = {
                    valueCallStatus: call.result.id,
                    notes: call.notes
                };
                this.$store.dispatch("TOOTGLE_SHOW", payload);
                this.$store.dispatch("UPDATE_LAST_ID", call);
            }
        }
    }
</script>
