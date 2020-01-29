<template>
    <table class="table  table-striped table-sm">
        <thead>
        <tr>
            <th>Nork</th>
            <th>Noiz</th>
            <th>Erantzuna</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="r in rowData">
            <td>{{r.user.username}}</td>
            <td>{{r.created}}</td>
            <td><span v-if="r.result">{{r.result.name}}</span></td>
            <th></th>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "CallTable",
        props: ['rowData']
    }
</script>
