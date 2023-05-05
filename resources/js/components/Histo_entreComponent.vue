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
                            <a class="nav-link myNav" style="border-radius: 4px !important;" @click="deleteAll" href="#">
                                <i class="la flaticon-interface-5"></i> &nbsp;Supprimer</a>
                        </li>
                    </ul>
                    &nbsp;&nbsp;
                </div>
                <div class="card-body" id="myDiv">
                    <div class="table-responsive anime fadeIn">
                        <table id="articleTable" class="display table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="no-sort" @click.self="checkAll = checkAll ? false : true ">
                                        <label class="check-container">
                                            <input type="checkbox" v-model="checkAll">
                                            <span class="checkmark"></span>
                                        </label>
                                    </th>
                                    
                                    <th>Designation</th>
                                    <th>Source</th>
                                    <th>Quantité </th>
                                    <th>Date</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th id="checkable" @click.self="checkAll = checkAll ? false : true ">
                                        <label class="check-container">
                                            <input type="checkbox" v-model="checkAll">
                                            <span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th>Designation</th>
                                    <th>Source</th>
                                    <th>Quantité</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            
                            <tbody>
                                <tr v-for="(kit, index) in kits" :key="kit.id_e" :id="kit.id_e">
                                    <td @click.self="check(kit.id_e)" id="checkable">
                                        <label class="check-container">
                                            <input type="checkbox" :value="kit.id_e" v-model="checkList">
                                            <span class="checkmark"></span>
                                        </label>
                                    </td>
                                    <td>{{ kit.design }}</td>
                                    <td>{{ kit.source }}</td>
                                    <td>{{ kit.qte_entre | splitNumber }}</td>
                                    <td>{{ kit.date_entre  }}</td>
                                    <td>
                                        <div class="form-button-action">
                                            <button id="action" type="button" @click="update(kit)" class="btn btn-link" data-toggle="modal" data-target="#exampleModal">
                                                <i class="fa fa-edit"></i><span id="bob">Modifier</span>
                                            </button>
                                            <button @click="deleteKit(kit.id_e)" id="action2" type="button" class="btn btn-link">
                                                    <i class="fa fa-trash"></i><span id="bob">Supprimer</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <!--{{ kit }}-->
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i style="font-size:.9rem" class="fa fa-edit"></i> update stock</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="mybasic3"><b>Designation :</b></span>
                                        </div>
                                        <input type="text" v-model="kit.design" placeholder="designation" readonly class="form-control readon modal-input">
                                    </div>
                                </div>
                                
                                <div class="form-group" style="margin-top:10px">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="mybasic3"><b>Quantité :</b></span>
                                                </div>
                                                 <input @keydown="errors.qte_entre = ''" type="text" v-model.number="kit.qte_entre" placeholder="Quantité" class="form-control modal-input">
                                            </div>
                                            <small v-for="er in errors.qte_entre" style="margin-top: 7px;" 
                                             class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i> {{ er }}</small>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control modal-input datepicker" id="datepicker" placeholder="dd-mm-yy">
                                            <small v-for="er in errors.date_entre" style="margin-top: 7px;" 
                                             class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i> {{ er }}</small>
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
import { supression, supressionAll,informer } from './../alert.js';
    export default {
        data() {
            return{
                ref: '',
				table: '',
                checkAll: false,
                checkList: [],
                errors: [],
                kit: {id_e: '',id_a: '', design: '', qte_entre: '', date_entre: ''},
                picker: '',
                kits: []
            }
        },
        mounted() {
            this.$root.$emit('activeLink','histo');
            this.ref = $('#articleTable');
            this.getHisto();

            $('.datepicker').datepicker('destroy');
            $('#datepicker').addClass('form-control modal-input datepicker'); 
            var picker = $('.datepicker').datepicker({
                locale: 'fr-fr',
                uiLibrary: 'bootstrap4',
                format: 'dd-mm-yyyy',
                value: ''
            }).on("change",() => {
                this.kit.date_entre = picker.value();
                this.errors.date_entre = '';
            });
            this.picker = picker;

        },
        watch: {
            checkAll : function(val){
                this.react(val);
            }
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
            getHisto(){
                return axios.get('/histo_entre')
                .then(
                    res => {
                        this.kits = res.data;
						//console.log(this.kits);
                        if ($.fn.DataTable.isDataTable('#articleTable')) {this.table.destroy();}
                        this.activeDataTable();
                    }
                ).catch(error => console.log(error));
            },
            react(val){
                this.checkList = [];
                if(val){
                    for(let i=0; i< this.kits.length;i++){
                        this.checkList.push(this.kits[i].id_e);
                    }
                }
            },
            check(id){
                if(this.checkList.includes(id)){
                    const index = this.checkList.findIndex(i => i === id);
                    this.checkList.splice(index, 1);
                }else{
                    this.checkList.push(id);
                }
            },
            deleteKit(id){
                supression('/del_entre/'+id).then((res) => {
                    if(res){
                        this.kits = this.kits.filter(i => i.id_e != id);
                        this.table.rows('#'+id).remove().draw(false);
                        const index = this.checkList.findIndex(i => i === id);
                        this.checkList.splice(index, 1);
                    }
                });
            },
            update(kit){
                this.kit.id_e = kit.id_e;
                this.kit.id_a = kit.id_a;
                this.kit.design = kit.design;
                this.kit.qte_entre = kit.qte_entre;
                this.kit.date_entre = kit.date_entre;
                this.picker.value(kit.date_entre);
            },
            updateRow(kit){
                const index = this.kits.findIndex(i => i.id_e == kit.id_e);
                this.kits[index].qte_entre = kit.qte_entre;
                this.kits[index].date_entre = kit.date_entre;
            },
            save(){
                axios.put('/update_entre',this.kit).then((res) => {
                    if(res.data >= 0){
                        //console.log(res.data);
                        this.updateRow(this.kit);
                        this.kit.design = '';
                        this.kit.qte_entre = '';
                        this.kit.date_entre = '';
                        this.picker.value('');
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
            deleteAll(){
                if(this.checkList.length > 0){
                    supressionAll(this.checkList,'/del_entres').then((res) => {
                        if(res){
                             this.getHisto();
                             this.checkAll = false;
                             this.checkList = [];
                        }  
                    }).catch(error => console.log(error));
                }else{
                    informer("Selectionner un élément svp !");
                }
            }
        }
    }
</script>