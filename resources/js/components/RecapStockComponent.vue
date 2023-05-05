<template>

    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span id="cardTitle" class="h4"><i class="fas fa-hockey-puck"></i>&nbsp;&nbsp;Articles</span>
                    
                     <ul id="myNav" class="nav nav-pills nav-secondary">
                        <li class="nav-item">
                            <router-link class="nav-link myNav" to="/recap"><i class="la flaticon-share"></i> &nbsp;Distribution</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link myNav" to="/recap_stock">
                            <i class="flaticon-cloud"></i> &nbsp;Etat stock</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link myNav" to="/other">
                            <i class="flaticon-graph-2"></i> &nbsp;Histogramme</router-link>
                        </li>
                    </ul>
                    <ul id="myNav" style="margin-right:12px;" class="nav nav-pills nav-secondary">
                        <li class="nav-item">
                            <a class="nav-link myNav" style="border-radius: 4px !important;" @click="toPDF" href="#">
                                  <i class="fas fa-file-pdf"></i> &nbsp;PDF</b></a>
                        </li>
                    </ul>
                </div>
                <div class="card-body" id="myDiv">
                    <div class="table-responsive anime fadeIn">
                        <table id="articleTable" class="display table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Article</th>
                                    <th>Source</th>
                                    <th>Qté recue</th>
                                    <th>Distribué</th>
                                    <th>En stock</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Article</th>
                                    <th>Source</th>
                                    <th>Qté recue</th>
                                    <th>Distribué</th>
                                    <th>En stock</th>
                                </tr>
                            </tfoot>
                            
                            <tbody>
                                <tr v-for="(kit, index) in done" :key="kit.id_e" :id="kit.id_e">
                                    <td>{{ kit.design }}</td>
                                    <td>{{ kit.source }}</td>
                                    <td>{{ kit.qte_recue | splitNumber}}</td>
                                    <td>{{ kit.qte_distribue | splitNumber}}</td>
                                    <td>{{ kit.qte_stock | splitNumber}}</td>
                                </tr>
                            </tbody>
                        </table>
                    <!--{{ kit }}-->
                    </div>
                </div>
            </div>
        </div>

	</div>
    
</template>

<script>
import { supression, supressionAll,informer } from './../alert.js';
    export default {
        data() {
            return{
                ref: '',
				table: '',
                done: []
            }
        },
        mounted() {
            this.$root.$emit('activeLink','recap');
            this.ref = $('#articleTable');
            this.getHisto();

        },
        
        methods:{
            activeDataTable(){
                this.$nextTick(() => {
                    this.table = this.ref.DataTable({
                	"pageLength": 5
				    });
                });
			},
            toPDF(){
                axios.get('/recapStockPdf').then(res =>{});
            },
            getHisto(){
                return axios.get('/recap_stock')
                .then(
                    res => {
                        this.done = res.data;
						//console.log(this.kits);
                        if ($.fn.DataTable.isDataTable('#articleTable')) {this.table.destroy();}
                        this.activeDataTable();
                    }
                ).catch(error => console.log(error));
            }
            
        }
    }
</script>