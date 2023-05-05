<template>
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span id="cardTitle" class="h4"><i class="fas fa-hockey-puck"></i>&nbsp;&nbsp;Articles</span>
                    
                    <ul id="myNav" class="nav nav-pills nav-secondary">
                        <li class="nav-item">
                            <router-link class="nav-link myNav" to="/etablissement">
                                <i class="flaticon-home"></i> &nbsp;Etablissement</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link myNav" to="/list_etab">
                                <i class="la flaticon-list"></i> &nbsp;Liste</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link myNav" to="/effectifs_eleves">
                                <i class="la flaticon-profile-1"></i> &nbsp;Effectif Eleves</router-link>
                        </li>
                    </ul>
                    <ul id="myNav" style="margin-right:12px;"  class="nav nav-pills nav-secondary">
                        <li class="nav-item">
                            <router-link class="nav-link myNav" to="/effectifs_eleves">EPP</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link myNav" to="/effectifs_eleves/ceg">CEG</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link myNav" to="/effectifs_eleves/lycee">LYCEE</router-link>
                        </li>
                    </ul>
                    &nbsp;&nbsp;
                  
                </div>
                <div class="card-body" id="myDiv">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group" style="padding:0px !important;margin-left: 15px;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="mybasic"><b>Cisco</b></span>
                                    </div>
                                    <select class="form-control form-control-sm cisco" data-placeholder="selectionner">
                                        <option value=""></option>
                                        <option v-for="c in ciscos" :value="c.id_cisco">{{ c.lieu_cisco }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" style="padding:0px !important;margin-left: 15px;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="mybasic"><b>Zap</b></span>
                                    </div>
                                    <select class="form-control zap" data-placeholder="selectionner">
                                        <option value=""></option>
                                        <option v-for="z in zaps" :value="z.id_zap">{{ z.lieu_zap }}</option>
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
                            <table id="histoTable3" class="display table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <td>Code</td>
                                        <th>Etablissement</th>
                                        <th>Seconde</th>
                                        <th>Premiere</th>
                                        <th>Terminale</th>
                                        
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <tr v-for="(etab, index) in etabs" :key="etab.id_etab" :id="etab.id_etab">
                                        
                                        <td>{{ etab.code_etab }}</td>
                                        <td>{{ etab.nom_etab }}</td>
                                        <td>{{ etab.seconde | splitNumber }}</td>
                                        <td>{{ etab.premiere | splitNumber }}</td>
                                        <td>{{ etab.terminale | splitNumber }}</td>
                                        <td>{{ etab.total | splitNumber }}</td>
                                        <td>
                                            <div class="form-button-action">
                                                <button id="action" @click="update(etab)" type="button"  data-toggle="modal" data-target="#exampleModal" class="btn btn-link" >
                                                    <i class="fa fa-edit"></i><span id="bob">Edit</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>                                                 
                           <!--{{ checkList }} {{ kit }} {{ etab }}-->
                       </div>
                   </div>
                </div>
            </div>
        </div> 

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i style="font-size:.9rem" class="fa fa-edit"></i> update</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                    
    
                                   
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group" >
                                                    <label for="design"><b>Nom Etablissement :</b></label>
                                                    <input type="text" readonly v-model="etab.nom_etab" class="form-control readon modal-input" id="design" placeholder="designation">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="presco"><b>Seconde :</b></label>
                                                    <input type="text" v-model.number="etab.classe.seconde" @keydown="errors['classe.seconde'] = null" class="form-control" id="presco" placeholder="Entier">
                                                    <small v-for="er in errors['classe.seconde']"
                                                     class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>{{ " "+er }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="eff"><b>Première :</b></label>
                                                    <input type="text" v-model.number="etab.classe.premiere" @keydown="errors['classe.premiere'] = null" class="form-control" id="eff" placeholder="Entier">
                                                    <small v-for="er in errors['classe.premiere']"
                                                     class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>{{ " "+er }}
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group" style="margin-bottom:10px;">
                                                    <label for="eff"><b>Terminale :</b></label>
                                                    <input type="text" v-model.number="etab.classe.terminale" @keydown="errors['classe.terminale'] = null" class="form-control" id="eff" placeholder="Entier">
                                                    <small v-for="er in errors['classe.terminale']"
                                                        class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>{{ " "+er }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                   
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="padding-right: 1.5rem;">
                        <button class="btn btm-sm modal-btn" data-dismiss="modal">Close</button>
                        <button class="btn btm-sm modal-btn" style="background: #42b983 !important;color: #fff;" @click.prevent="save">Save</button>
                    </div>
                </div>
            </div>
        </div>
	</div>
        
    
</template>

<script>
import { supression, supressionAll,informer,reussie } from './../alert.js';
    export default {
        data() {
            return{
                 ref3: '',
				table3: '',
                ciscos: [], zaps: [], niveau: '',
                select1: '', select2: '', 
               
                etabs: [], etab: { id_etab: '',niveau: '', nom_etab : '', classe: {}},

                errors: [],
               
              
            }
        },
        mounted() {
            this.$root.$emit('activeLink','etab');
            
            this.ref3 = $('#histoTable3');

            this.getCisco();

            this.activeDataTable3();
            /*this.activeDataTable(this.table2,this.ref2);
            this.activeDataTable(this.table3,this.ref3);*/


            var select1 = $('.cisco').select2({theme: 'bootstrap4'}).on('change',() => { 
                this.getZap(select1.val());
            });
            var select2 = $('.zap').select2({theme: 'bootstrap4'}).on('change',() => {
                console.log(select2.val());
            });
           
            this.select1 = select1; this.select2 = select2;
           
        },
        
        methods:{
            getCisco(){
                return axios.get('/getlistCisco').then(res => { this.ciscos = res.data.ciscos});
            },
            getZap(id){
                this.zaps = [];
                return axios.get('/getzap/'+id).then(res => { this.zaps = res.data});
            },
            valider(){
                this.niveau = 'LYCEE';
                if(this.select2.val()){
                    this.getClasse(this.select2.val());
                }
            },
            
            activeDataTable3(){
                this.$nextTick(() => {
                    this.table3 = this.ref3.DataTable({
                	"pageLength": 5
				    });
                });
			},
            getClasse(idZap){ 
                //console.log(this.niveau);
                //console.log(id);
                return axios.get('/effectifs_classe/' + idZap + '/'+ this.niveau).then(res => {
						//console.log(res.data)
                     this.etabs = res.data;

                    //console.log(this.table3);
                    if ($.fn.DataTable.isDataTable('#histoTable3')) {this.table3.destroy();}
                    this.activeDataTable3();
                        
                    
                }).catch((error) => {console.log(errors);});
            },
            updateRow(etab){
                const index = this.etabs.findIndex(i => i.id_etab == etab.id_etab);
                
                this.etabs[index].seconde = etab.classe.seconde;
                this.etabs[index].premiere = etab.classe.premiere;
                this.etabs[index].terminale = etab.classe.terminale;
                this.etabs[index].total = etab.classe.seconde + etab.classe.premiere
                    + etab.classe.terminale;
                
            },
            update(param){
                this.errors = []; 
                this.etab.id_etab = param.id_etab;
                this.etab.nom_etab = param.nom_etab;
                this.etab.niveau = this.niveau;
                this.etab.classe = {};
                this.etab.classe.seconde = param.seconde;
                this.etab.classe.premiere = param.premiere;
                this.etab.classe.terminale = param.terminale;
            },
            save(){
                axios.post('/update_classe',this.etab).then((res) => {
                    if(res.data){
                        this.updateRow(this.etab);
                        this.etab.classe = {};
                        $('#exampleModal').modal('hide');
                        reussie();
                    }
                }).catch((er) => {
                    if(er.response.status == 422){
                        this.errors = er.response.data.errors;
                        console.log(this.errors);
                    }
                });
            }
        }
    }
</script>