<template>
    <router-view></router-view>
</template>

<script>
import { supression, supressionAll,informer } from './../alert.js';
    export default {
        data() {
            return{
               
              
            }
        },
        mounted() {
            this.$root.$emit('activeLink','etab');
           
        },
        
        methods:{

        }
    }
</script>