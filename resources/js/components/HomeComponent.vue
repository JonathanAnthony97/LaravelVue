<template>
    
</template>

<script>
import { required, minLength, between, minValue ,numeric } from 'vuelidate/lib/validators';

    export default {
        
        data(){
            return{
				
            }
        },
        
        mounted() {
            this.$root.$emit('activeLink','home');
        },
        methods: {
        
        }
    }
</script>
