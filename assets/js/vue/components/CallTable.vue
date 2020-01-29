<template>
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
</template>

<script>
    export default {
        name: "CallTable",
        props: ['rowData']
    }
</script>
