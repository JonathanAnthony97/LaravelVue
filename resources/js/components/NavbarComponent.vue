<template>

    <div class="main-header">
    <!-- Logo Header -->
    <div class="logo-header">
        
        <a href="index.html" class="logo">
            <img id="logo" src="assets/img/logo.jpg" alt="navbar brand" class="navbar-brand"><b id="men">&nbsp;MEN</b>
        </a>
        
    </div>
    <!-- End Logo Header -->

    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-expand-lg">

        <div class="container-fluid">
            <div class="row">
                <ul class="nav nav-line ">
                    <!--li class="nav-item">
                        <router-link class="nav-link" to="/"><i class="flaticon-home"></i>&nbsp;Home</router-link>
                    </li-->
                    <li class="nav-item dropdown">
                        <a class="nav-link" :class="{ active: isActive === 'article' }"
                           data-toggle="dropdown" href="#"><i class="la flaticon-layers"></i>&nbsp;
                            Articles&nbsp;<span style="vertical-align:0.15em" class="caret"></span></a>
                            
                            <ul class="dropdown-menu persona">
                                <router-link class="dropdown-item" id="first" to="/">Liste des articles</router-link>
                                <div class="dropdown-divider"></div>
                                <router-link class="dropdown-item" to="/addkit">Ajout stock</router-link>
                                <div class="dropdown-divider"></div>
                                <router-link class="dropdown-item" to="/addkit/defect">
                                   Articles defectueux</router-link>
                            </ul>
                    </li>


                    <li class="nav-item dropdown">
                        <a class="nav-link" :class="{ active: isActive === 'dist' }"
                           data-toggle="dropdown" href="#"><i class="flaticon-cloud"></i>&nbsp;
                           Stock&nbsp;<span style="vertical-align:0.15em" class="caret"></span></a>
                            <ul class="dropdown-menu persona">
                                <router-link id="first" class="dropdown-item" to="/">
                                    Stock Dren
                                </router-link>
                                <div class="dropdown-divider"></div>
                                <router-link class="dropdown-item" to="/dist">
                                    Stock Cisco
                                </router-link>
                            </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link" :class="{ active: isActive === 'histo' }"
                           data-toggle="dropdown" href="#"><i class="flaticon-folder"></i>&nbsp; 
                           Historique&nbsp;<span style="vertical-align:0.15em" class="caret"></span></a>
                            <ul class="dropdown-menu persona">
                                <router-link id="first" class="dropdown-item" to="/histo_entre">
                                    Entrée
                                </router-link>
                                <div class="dropdown-divider"></div>
                                <router-link class="dropdown-item" to="/histo_repart">
                                    Repartition
                                </router-link>
                                <div class="dropdown-divider"></div>
                                <router-link class="dropdown-item" to="/histo_dist">
                                    Distribution
                                </router-link>
                            </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link" :class="{ active: isActive === 'etab' }"
                           data-toggle="dropdown" href="#"><i class="flaticon-home"></i>&nbsp;
                           Etablissement&nbsp;<span style="vertical-align:0.15em" class="caret"></span></a>
                            <ul class="dropdown-menu persona">
                                <router-link id="first" class="dropdown-item" to="/etablissement">
                                    Ajouter 
                                </router-link>
                                <div class="dropdown-divider"></div>
                                <router-link class="dropdown-item" to="/list_etab">
                                    Liste
                                </router-link>
                                <div class="dropdown-divider"></div>
                                <router-link class="dropdown-item" to="/effectifs_eleves">
                                    Effectif Eleves
                                </router-link>
                           
                            </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link" :class="{ active: isActive === 'recap' }"
                           data-toggle="dropdown" href="#"><i class="flaticon-list"></i>&nbsp;
                           Bilan&nbsp;<span style="vertical-align:0.15em" class="caret"></span></a>
                            <ul class="dropdown-menu persona">
                                <router-link id="first" class="dropdown-item" to="/recap">
                                    Distribution
                                </router-link>
                                <div class="dropdown-divider"></div>
                                <router-link class="dropdown-item" to="/recap_stock">
                                    Stock
                                </router-link>
                                <div class="dropdown-divider"></div>
                                <router-link class="dropdown-item" to="/other">
                                    Statistique
                                </router-link>
                            </ul>
                    </li>
                    
                </ul>
                
               
            </div>
            &nbsp; &nbsp; &nbsp; &nbsp;
            <!--<div class="collapse" id="search-nav">
                <form class="navbar-left navbar-form nav-search mr-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button type="submit" class="btn btn-search pr-1">
                                <i class="fa fa-search search-icon"></i>
                            </button>
                        </div>
                        <input type="text" placeholder="Search ..." class="form-control searchinput">
                    </div>
                </form>
            </div>-->
            
            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                
    
                <li class="nav-item dropdown hidden-caret">
                    
                    <a class="nav-link dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-sign-out-alt"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item  persona2" href="#">Account Setting</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item persona2" href="#" @click.prevent="logout()">Logout</a>
                        </li>
                    </ul>
                </li>
                
            </ul>
        </div>
    </nav>
   <!-- End Navbar -->
    
    
</div>

</template>

<script>
    export default {
        data: function(){
            return{
                isActive: 'home',
                subActive: ''
            }
        },
        mounted() {
            this.$root.$on('activeLink',
            (data) => { this.isActive = data; });

            this.$root.$on('subLink',
            (data) => { this.subActive = data; });

        },
        methods: {
            navig(){
                this.$router.push('/dist');
            },
            toEtab(){
                this.$router.push('/etablissement');
            },
            toRecap(){
                this.$router.push('/recap');
            },
            logout: function() {
                axios.post('/logout').then(
                    response => { 
                        window.location.href = '/login';
                    });
            }
            
        }
    }
</script>


