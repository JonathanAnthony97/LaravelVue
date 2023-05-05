<template>
    
            <h1>Task3</h1>
</template>

<script>
    export default {
        mounted() {
            this.$root.$emit('activeLink','lien');
            this.$root.$emit('subLink','task3');
        }
    }
</script>
