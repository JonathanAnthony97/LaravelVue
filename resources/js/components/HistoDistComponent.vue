<template>
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span id="cardTitle" class="h4"><i class="fas fa-hockey-puck"></i>&nbsp;&nbsp;Articles</span>
                    
                    <ul id="myNav" class="nav nav-pills nav-secondary">
                        <li class="nav-item">
                            <router-link class="nav-link myNav" to="/histo_entre"><i class="la flaticon-circle"></i> &nbsp;Entrée</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link myNav" to="/histo_repart"><i class="la flaticon-network"></i> &nbsp;Répartitions</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link myNav" to="/histo_dist">
                                <i class="la flaticon-share"></i> &nbsp;Distributions</router-link>
                        </li>
                    </ul>
                    <ul id="myNav" style="margin-right:12px;" class="nav nav-pills nav-secondary">

                        <li class="nav-item">
                            <a class="nav-link myNav" style="border-radius: 4px !important;" @click="find" href="#">
                            <i class="la flaticon-multimedia"></i> &nbsp;Recherche</a>
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
                                    <select class="form-control cisco" data-placeholder="selectionner">
                                        <option value=""></option>
                                        <option v-for="c in ciscos" :value="c.id_cisco">{{ c.lieu_cisco }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" style="padding:0px !important">
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
                        <div class="col-md-3">
                            <div class="form-group" style="padding:0px !important">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="mybasic"><b>Etab</b></span>
                                    </div>
                                    <select class="form-control etab" data-placeholder="selectionner">
                                        <option value=""></option>
                                        <option v-for="c in etabs" :value="c.id_etab">{{ c.niveau+ ' - ' +c.nom_etab }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" style="padding:0px !important;margin-right: 15px;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="mybasic"><b>Beneficiaire</b></span>
                                    </div>
                                    <select class="form-control benef">
                                        <option value="El">Eleve</option>
                                        <option value="En">Enseignant</option>
                                        <option value="Et">Etablissement</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--div class="col-md-3" style="margin-top: 4px;">
                            <button class="btn btn-sm" @click="valider" style="border:1px solid #ced4da !important;margin-right: 15px;">Valider</button>     
                        </div-->
                    </div>
                    <div class="row">
                       <div class="col-md-12 anime fadeIn" style="margin-top: 22px;">
                            <table id="histoTable" class="display table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Etablissement</th>
                                        <th v-show="react == 'El'" style="min-width:90px">Classe</th>
                                        <th>Article</td>
                                        <th>Unité Dist</th>
                                        <th>Beneficiaire</th>
                                        <th>Distribué</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <tr v-for="(kit, index) in done" :key="index" :id="index">
                                        <td>{{ kit.nom_etab }}</td>
                                        <td v-show="react == 'El'">{{ kit.nom_cls }}</td>
                                        <td>{{ kit.design }}</td>
                                        <td>{{ kit.unite_dist | splitNumber }}</td>
                                        <td>{{ kit.eff_benef | splitNumber }}</td>
                                        <td>{{ kit.qte_dist | splitNumber }}</td>
                                        <td>{{ kit.date_dist }}</td>
                                        <td>
                                            <div class="form-button-action">
                                                <button id="action" type="button" @click="delDist(kit.id_dist,index)" class="btn btn-link" >
                                                    <i class="fa fa-trash"></i><span id="bob">&nbsp;Supprimer</span>
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
				table: '', ciscos: [],
                etabs: [], zaps: [],
                select1: '', select2: '',select3: '', select4: '',
                done: [], benef: '',
                res: '',react: 'El'
            }
        },
        mounted() {
            this.$root.$emit('activeLink','histo');
            this.ref = $('#histoTable');
            this.getCisco();
            
            //this.getEtab();
          
            var select1 = $('.cisco').select2({theme: 'bootstrap4'}).on('change',() => {
                this.getZap(select1.val());
            });
            var select2 = $('.zap').select2({theme: 'bootstrap4'}).on('change',() => {
                this.getEtab(select2.val());
            });

            var select3 = $('.etab').select2({theme: 'bootstrap4'}).on('change',() => { 
                //this.benef = select2.val();
            });
            var select4 = $('.benef').select2({theme: 'bootstrap4'}).on('change',() => { 
                //this.react = select4.val();
            });

            this.select1 = select1;
            this.select2 = select2;
            this.select3 = select3;
            this.select4 = select4;

            //this.getData();
            this.activeDataTable();
        },
        methods:{
            getCisco(){
                return axios.get('/getlistCisco').then(res => { this.ciscos = res.data.ciscos});
            },
            getZap(id){
                this.zaps = [];
                return axios.get('/getzap/'+id).then(res => { this.zaps = res.data});
            },
            getEtab(id){
                this.etabs = [];
                return axios.get('/getetab/'+id).then(res => { this.etabs = res.data});
            },
            valider(){
                this.benef = this.select2.val();
                if(this.select1.val()){
                    this.getData(this.select1.val());
                }else{
                    informer("Selectioner un etablissement svp !");
                }
            },
            activeDataTable(){
                this.$nextTick(() => {
                    this.table = this.ref.DataTable({
                	"pageLength": 5
				    });
                });
			},
            find(){
                if(this.select3.val()){
                    this.getData(this.select3.val());
                }else{
                    informer("Selectioner un etablissement svp !");
                }
            },
            getData(id){
                const benef = this.select4.val();
                return axios.get('/histo_dist/'+ benef +'/' + id).then(
                    res => {
                        this.done = res.data;
						//console.log(this.done);
                        if ($.fn.DataTable.isDataTable('#histoTable')) {this.react = this.select4.val()
                            this.table.destroy();;
                            }
                            this.activeDataTable();
                    }
                ).catch(error => console.log(error));
            },
            detail(res){
                this.$router.push({name: 'detail', params: { res: res}});
            },
            delDist(id,index){
                supression('/del_dist/'+id).then((res) => {
                    if(res){
                        console.log(res);
                        this.done = this.done.filter(i => i.id_dist != id);
                        this.table.rows('#'+index).remove().draw(false);
                    }
                });
            }
        }
    }
</script>