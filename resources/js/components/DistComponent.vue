<template>
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span id="cardTitle" class="h4"><i class="fas fa-hockey-puck"></i>&nbsp;&nbsp;Articles</span>
                    
                    <ul id="myNav" class="nav nav-pills nav-secondary">
                        <li class="nav-item">
                            <router-link class="nav-link myNav" to="/dist">CISCO</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link myNav" to="/">DREN</router-link>
                        </li>
                    </ul>
                </div>
                <div class="card-body" id="myDiv">
                    <router-view></router-view>
                </div>
            </div>
        </div> 
	</div>
</template>

<script>
    export default {
        data() {
            return{
              
            }
        },
        mounted() {
            //this.$root.$emit('activeLink','dist');
        }
    }
</script>

