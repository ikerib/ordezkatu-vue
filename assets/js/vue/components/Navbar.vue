<template>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
        <h5>Zerrenda: {{ zerrendaName }}</h5>
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
