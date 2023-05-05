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
                </div>
                <div class="card-body" id="myDiv">
                    <div class="table-responsive anime fadeIn">
                        <table id="articleTable" class="display table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="no-sort" style="width: 4%;text-align: center;">#</th>
                                    <th>Cisco</th>
                                    <th>Zap</th>
                                    <th>Code</th>
                                    <th>Niveau</th>
                                    <th>Nom</th>
                                    
                                    <th>Enseignant</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="no-sort" style="width: 4%;text-align: center;">#</th>
                                    <th>Cisco</th>
                                    <th>Zap</th>
                                    <th>Code</th>
                                    <th>Niveau</th>
                                    <th>Nom</th>
                                    
                                    <th>Enseignant</th>
                                    
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            
                            <tbody>
                                <tr v-for="(etab, index) in etabs" :key="etab.id_etab" :id="etab.id_etab">
                                    <td style="text-align:center"><b>{{ index + 1 }}</b></td>
                                    <td>{{ etab.lieu_cisco }}</td>
                                    <td>{{ etab.lieu_zap }}</td>

                                    <td>{{ etab.code_etab }}</td>
                                    <td>{{ etab.niveau }}</td>
                                    <td>{{ etab.nom_etab }}</td>
                                   
                                    <td>{{ etab.eff_ens | splitNumber }}</td>
                                    
                                    <td>
                                        <div class="form-button-action">
                                            <button id="action" type="button" @click="update(etab)" class="btn btn-link" data-toggle="modal" data-target="#exampleModal">
                                                <i class="fa fa-edit"></i><span id="bob">Edit</span>
                                            </button>
                                            <button @click="deleteEtab(etab.id_etab)" id="action2" type="button" class="btn btn-link">
                                                    <i class="fa fa-trash"></i><span id="bob">Delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <!--{{ etab }}-->
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
                                <!--div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="code"><b>Code :</b></label>
                                            <input type="text" v-model.trim="etab.code_etab" @keydown="errors.code_etab = null" class="form-control" id="code" placeholder="code ...">
                                            <small v-for="er in errors.code_etab"
                                                class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>{{ " "+er }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="zap"><b>Zap :</b></label>
                                            <select class="form" id="zap">
                                                <option v-for="z in zaps" :value="z.id_zap">{{ z.lieu_zap }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div-->
                                
                                <div class="form-group" >
                                    <label for="design"><b>Nom Etablissement :</b></label>
                                    <input type="text" v-model="etab.nom_etab" @keydown="errors.nom_etab = null" class="form-control" id="design" placeholder="designation">
                                    <small v-for="er in errors.nom_etab"
                                     class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>{{ " "+er }}
                                    </small>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="ens"><b>Nombre Enseignant :</b></label>
                                            <input type="text" v-model.number="etab.enseignant" @keydown="errors.enseignant = null" class="form-control" id="ens" placeholder="Entier">
                                            <small v-for="er in errors.enseignant" class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>{{ " "+er }}</small>
                                        </div>
                                    </div>
                                </div>   
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="padding-right: 1.5rem;">
                        <button class="btn btm-sm modal-btn" data-dismiss="modal" @click="close">Close</button>
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
                ref: '',
				table: '',
                errors: [], select1: '',
                etab: { id_etab: '',code_etab: '', zap: '', nom_etab : '', enseignant: ''},
                zaps : [],
                etabs: []
            }
        },
        mounted() {
            this.$root.$emit('activeLink','etab');
            this.ref = $('#articleTable');
            this.getEtabs();
            this.getZap();
            var select1 = $('#zap').select2({theme: 'bootstrap4',dropdownParent: $('#exampleModal')}).on('change',() => {
                this.etab.zap = select1.val();
            });
            
            this.select1 = select1;
            
        },
        methods:{
            activeDataTable(){
                this.$nextTick(() => {
                    this.table = this.ref.DataTable({
                	"pageLength": 5,
                    columnDefs: [
                        {orderable: false, targets: 0}
                    ]
				    });
                });
			},
            getZap(){
                axios.get('/getzap').then(res => { this.zaps = res.data;  });
            },
            getEtabs(){
                return axios.get('/etab_list')
                .then(
                    res => {
                        this.etabs = res.data;
						//console.log(this.kits);
                        if ($.fn.DataTable.isDataTable('#articleTable')) {this.table.destroy();}
                        this.activeDataTable();
                    }
                ).catch(error => console.log(error));
            },
            deleteEtab(id){
                supression('/del_etab/'+id).then((res) => {
                    if(res){
                        this.etabs = this.etabs.filter(i => i.id_etab != id);
                        this.table.rows('#'+id).remove().draw(false);
                    }
                });
            },
            update(etab){
                this.errors = [];
                this.etab.id_etab = etab.id_etab;
                this.etab.code_etab = etab.code_etab;
                this.etab.zap = etab.id_zap;
                this.select1.val(etab.id_zap).trigger('change');
                this.etab.nom_etab = etab.nom_etab;
                this.etab.enseignant = etab.eff_ens;

            },
            updateRow(etab){
                const index = this.etabs.findIndex(i => i.id_etab == etab.id_etab);
                this.etabs.splice(index, 1, etab);
            },
            save(){
                this.etab.zap = this.select1.val();
                axios.post('/update_etab',this.etab).then((res) => {
                    if(res.data.updated){
                        //console.log(res.data.updated);
                        this.updateRow(res.data.updated);
                        this.etab.code_etab = '';
                        this.etab.nom_etab = '';
                        this.etab.enseignant = '';
                        $('#exampleModal').modal('hide');
                        reussie();
                    }
                }).catch((er) => {
                    if(er.response.status == 422){
                        this.errors = er.response.data.errors;
                        console.log(this.errors);
                    }
                });
            },
            close(){

            },
            deleteAll(){
            }
        }
    }
</script>