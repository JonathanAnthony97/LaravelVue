<template>
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span id="cardTitle" class="h4"><i class="fas fa-hockey-puck"></i>&nbsp;&nbsp;Bilan</span>
                    
                    <ul id="myNav" class="nav nav-pills nav-secondary">
                        <li class="nav-item">
                            <router-link class="nav-link myNav" to="/recap"><i class="la flaticon-circle"></i> &nbsp;Distribution</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link myNav" to="/recap_stock"><i class="la flaticon-cloud"></i> &nbsp;Etat stock</router-link>
                        </li>
                    </ul>
                    <ul id="myNav" style="margin-right:12px;" class="nav nav-pills nav-secondary">
                        <li class="nav-item">
                            <a class="nav-link myNav" style="border-radius: 4px !important;" @click="toPDF" href="#">
                                <i class="fas fa-file-pdf"></i> &nbsp;PDF</b></a>
                        </li>
                    </ul>
                    &nbsp;&nbsp;
                   
                </div>
                <div class="card-body" id="myDiv">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="mybasic4"><b>Etablissement :</b></span>
                                    </div>
                                    <input type="text" v-model="res.nom_etab" readonly class="form-control readon modal-input">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3" style="padding-left: 0px;">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="mybasic4"><b>Cisco :</b></span>
                                    </div>
                                    <input type="text" v-model="res.lieu_cisco" readonly class="form-control readon modal-input">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3" style="padding-left: 0px;">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="mybasic4"><b>Zap :</b></span>
                                    </div>
                                    <input type="text" v-model="res.lieu_zap" readonly class="form-control readon modal-input">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2" style="padding-left: 0px;">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="mybasic4"><b>Distribués :</b></span>
                                    </div>
                                    <input type="text" v-model="res.qte" readonly class="form-control readon modal-input">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                       <div class="col-md-12 anime fadeIn" style="margin-top: 22px;">
                            <table id="histoTable" class="display table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Article</td>
                                        <th>Source</th>
                                        <th>Beneficiaire</th>
                                        <th>Distribués </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <tr v-for="(res, index) in done" :key="done.id_a" :id="done.id_a">
                                        <td>{{ res.design }}</td>
                                        <td>{{ res.source }}</td>
                                        <td>{{ res.benef }}</td>
                                        <td>{{ res.qte | splitNumber }}</td>
                                        <td>
                                            <div class="form-button-action">
                                                <button id="action"  type="button" @click="histo(res)"  data-toggle="modal" data-target="#exampleModal" class="btn btn-link" >
                                                    <i class="fa fa-info"></i><span id="bob">&nbsp;historique</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!--{{ this.$route.params.res }}-->
                       </div>
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
                ref: '',res: '',
				table: '',
                done: [],
            }
        },
        mounted() {
            this.$root.$emit('activeLink','recap');
            this.ref = $('#histoTable');
            this.res = this.$route.params.res;
            if(this.res){
                this.getData(this.res.id_etab);
            }
           
            this.activeDataTable();

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
                axios.post('/recapDistPdf',this.res).then(res =>{});
                //window.location.href = 'test/';
            },
            getData(id_etab){
                //console.log(this);
                return axios.get('/detail_dist/' + id_etab + '/' + this.res.benef).then(
                    res => {
                        this.done = res.data;
						console.log(this.done);
                        if ($.fn.DataTable.isDataTable('#histoTable')) {this.table.destroy();}
                        this.activeDataTable();
                    }
                ).catch(error => console.log(error));
            },
            histo(param){
                this.$router.push('/histo_dist');
            }
        }
    }
</script>