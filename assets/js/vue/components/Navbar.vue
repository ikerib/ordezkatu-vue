<template>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
        <div class="col-md-10">
            <h5>Zerrenda: {{ zerrendaName }}</h5>
        </div>
    </nav>
</template>

<script>

    export default {

        name: 'Navbar',
        props: {
            zerrendaName: {
                type: String,
                required: true,
                default: '---'
            }
        }
    }

</script>
