<template>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
        <div class="row container">
            <div class="col-md-4"><h5><strong>Eskeintza</strong>: {{ jobName }}</h5></div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
        </div>
<!--        <div class="col-md-10">-->
<!--            <h5>// </h5>-->
<!--        </div>-->
    </nav>
</template>

<script>

    export default {

        name: 'Navbar',
        props: {
            jobName: {
                type: String,
                required: true,
                default: '---'
            }
        }
    }

</script>
