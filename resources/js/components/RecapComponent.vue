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
                    &nbsp;&nbsp;
                </div>
                <div class="card-body" id="myDiv">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group" style="padding:0px !important;margin-left: 15px;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="mybasic"><b>Cisco</b></span>
                                    </div>
                                    <select class="form-control form-control-sm depot" data-placeholder="selectionner">
                                        <option value=""></option>
                                        <option v-for="c in ciscos" :value="c.id_cisco">{{ c.lieu_cisco }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" style="padding:0px !important;margin-left: 15px;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="mybasic"><b>Beneficiaire</b></span>
                                    </div>
                                    <select class="form-control form-control-sm benef">
                                        <option value="El">Eleve</option>
                                        <option value="En">Enseignant</option>
                                        <option value="Et">Etablissement</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3" style="margin-top: 4px;">
                            <button class="btn btn-sm" @click="valider" style="border:1px solid #ced4da !important;margin-right: 15px;">Valider</button>     
                        </div>
                    </div>
                    <div class="row">
                       <div class="col-md-12 anime fadeIn" style="margin-top: 22px;">
                            <table id="histoTable" class="display table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Cisco</td>
                                        <th>Zap</th>
                                        <th>Etablissement</th>
                                        <th>Qté Distribués </th>
                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <tr v-for="(res, index) in done" :key="done.id_etab" :id="done.id_etab">
                                        <td>{{ res.lieu_cisco }}</td>
                                        <td>{{ res.lieu_zap }}</td>
                                        <td>{{ res.nom_etab }}</td>
                                        <td>{{ res.qte | splitNumber }}</td>
                                        <td>
                                            <div class="form-button-action">
                                                <button id="action"  type="button" @click="detail(res)"  data-toggle="modal" data-target="#exampleModal" class="btn btn-link" >
                                                    <i class="fa fa-info"></i><span id="bob">&nbsp;Detail</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
                ref: '',
				table: '',
                ciscos: [],
                select1: '',select2: '',
                done: [], benef: '',
                res: ''
            }
        },
        mounted() {
            this.$root.$emit('activeLink','recap');
            this.ref = $('#histoTable');
            
            
            this.getCisco();

            var select1 = $('.depot').select2({theme: 'bootstrap4'}).on('change',() => {
                
            });
            var select2 = $('.benef').select2({theme: 'bootstrap4'}).on('change',() => { 
                this.benef = select2.val();
                
            });
            this.select1 = select1;
            this.select2 = select2;
            this.getData('0');
            this.activeDataTable();

        },
        
        methods:{
            getCisco(){
                return axios.get('/getlistCisco').then(res => { this.ciscos = res.data.ciscos});
            },
            valider(){
                this.benef = this.select2.val();
                if(this.select1.val()){
                    this.getData(this.select1.val());
                }else{
                    informer("Selectioner un cisco svp !");
                }
            },
            activeDataTable(){
                this.$nextTick(() => {
                    this.table = this.ref.DataTable({
                	"pageLength": 5
				    });
                });
			},
            getData(id){
                //console.log(id);
                this.benef = this.select2.val();
                return axios.get('/recap_dist/' + id + '/' + this.benef).then(
                    res => {
                        this.done = res.data;
						//console.log(this.done);
                        if ($.fn.DataTable.isDataTable('#histoTable')) {this.table.destroy();}
                        this.activeDataTable();
                    }
                ).catch(error => console.log(error));
            },
            detail(res){
                this.$router.push({name: 'detail', params: { res: res}});
            }
        }
    }
</script>