<template>
    <div class="row">
        <div class="col-md-12">
            <router-view></router-view>
        </div>
        
    </div>
</template>

<script>
//import { required, minLength, between, minValue ,numeric } from 'vuelidate/lib/validators';
import { supression, supressionAll,reussie } from './../alert.js';
    export default {
        data(){
            return{
               
            }
        },
        mounted() {
            this.$root.$emit('activeLink','article');
            
        },
        methods: {
           
        }
    }
</script>

