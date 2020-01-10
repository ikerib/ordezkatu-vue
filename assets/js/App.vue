<template>
    <div>
        <h2>Kaixo</h2>
        <button @click="counter++">{{counter}}</button>
    </div>
</template>

<script>
    export default {
        name: "App",
        data: () => ({
            counter: 0
        })
    }
</script>

<style scoped>

</style>
