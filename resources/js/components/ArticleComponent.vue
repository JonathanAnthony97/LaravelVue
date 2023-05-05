<template>
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span id="cardTitle" class="h4"><i class="fas fa-hockey-puck"></i>&nbsp;&nbsp;Articles</span>
                    
                    <ul id="myNav" class="nav nav-pills nav-secondary">
                        <li class="nav-item">
                            <router-link class="nav-link myNav" to="/addkit"><i class="la flaticon-circle"></i> &nbsp;Ajouter Stock</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link myNav" to="/"><i class="flaticon-layers"></i> &nbsp;Articles</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link myNav" to="/addkit/defect"><i class="flaticon-line-1"></i> &nbsp;Defectueux</router-link>
                        </li>
                    </ul>
                    
                    <ul id="myNav" style="margin-right:12px;" class="nav nav-pills nav-secondary">
                            
                        <li class="nav-item">
                            <a class="nav-link myNav" @click="deleteAll" href="#"><i class="la flaticon-interface-5"></i> &nbsp;Supprimer</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link myNav" @click.prevent="repartir" href="#"><i class="la flaticon-network"></i> &nbsp;Repartir</a>
                        </li>
                    </ul>
                    &nbsp;&nbsp;

                </div>
                <div class="card-body anime fadeIn" id="myDiv">
                    <div class="table-responsive">
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
                                    <th>Quantité</th>
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
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            
                            <tbody>
                                <tr v-for="(kit, index) in kits" :key="kit.id_a" :id="kit.id_a">
                                    <td @click.self="check(kit.id_a)" id="checkable">
                                        <label class="check-container">
                                            <input type="checkbox" :value="kit.id_a" v-model="checkList">
                                            <span class="checkmark"></span>
                                        </label>
                                    </td>
                                    
                                    <td>{{ kit.design }}</td>
                                    <td>{{ kit.source }}</td>
                                    <td>{{ kit.qte_st | splitNumber }}</td>
                                    <td>
                                        <div class="form-button-action">
                                            <button id="action" type="button" @click="update(kit)" class="btn btn-link" data-toggle="modal" data-target="#exampleModal">
                                                <i class="fa fa-edit"></i><span id="bob">Modifier</span>
                                            </button>
                                            <button @click="deleteKit(kit.id_a)" id="action2" type="button" class="btn btn-link">
                                                    <i class="fa fa-trash"></i><span id="bob">Supprimer</span>
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
         <!-- Modal
        {{ checkList }} -->
       
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
                                
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="mybasic3"><b>Source :</b></span>
                                        </div>
                                        <select class="form-control modal-input source" data-placeholder="selectionner">
                                            <option></option>
                                            <option v-for="opt in sources" :value="opt.id_s">{{ opt.source }}</option>
                                        </select> 
                                    </div>
                                   
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="mybasic3"><b>Designation :</b></span>
                                        </div>
                                        <input @keydown="errors.design = ''" type="text" v-model.trim="kit.design" placeholder="designation" class="form-control modal-input">
                                    </div>
                                    <small v-for="er in errors.design" style="margin-top: 7px;" 
                                     class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i> {{ er }}</small>
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
    import { supression, supressionAll, informer, reussie } from './../alert.js';
    export default {
        data: function(){
            return{
				ref: '',
				table: '',
                checkAll: false,
                select: '',
                errors: [],
                checkList: [],
                kits: [], sources: [],
                kit : {id_a: '', design: '', Source: ''}
            }
            
        },
        mounted() {
            this.$root.$emit('activeLink','article');
            this.ref = $('#articleTable');
            this.getArticle(); 
        
            var select = $('.source').select2({theme: 'bootstrap4',dropdownParent: $('#exampleModal')})
            .on('change',() => { this.kit.Source = select.val();});
            this.select = select;
            //liste
            if(this.$route.params.list){
                this.checkList = this.$route.params.list;
            }
            this.getsource();
        },
        watch: {
            checkAll : function(val){
                this.react(val);
            }
        },
        methods: {
            getsource(){
                return axios.get('/getlistCisco').then(res => { this.sources = res.data.sources;});
            },
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
            react(val){
                this.checkList = [];
                if(val){
                    for(let i=0; i< this.kits.length;i++){
                        this.checkList.push(this.kits[i].id_a);
                    }
                }
            },
            getArticle(){
                return axios.get('/article')
                .then(
                    res => {
                        this.kits = res.data;
                        if ($.fn.DataTable.isDataTable('#articleTable')) {this.table.destroy();}
                        this.activeDataTable();
                    }
                ).catch(error => console.log(error));
            },
            deleteKit(id){
                supression('/article/'+id).then((res) => {
                    if(res){
                        this.kits = this.kits.filter(i => i.id_a != id);
                        this.table.rows('#'+id).remove().draw(false);
                        const index = this.checkList.findIndex(i => i === id);
                        this.checkList.splice(index, 1);
                    }
                });
            },
            deleteAll(){
                if(this.checkList.length > 0){
                    supressionAll(this.checkList,'/allDelete').then((res) => {
                        if(res){
                             this.getArticle();
                             this.checkAll = false;
                             this.checkList = [];
                        }  
                    }).catch(error => console.log(error));
                }else{
                    swal("", "Veuillez selectioner un élément svp !", {
						icon : "info",
						buttons: {        			
							confirm: {
								className : 'btn btn-info btn-sm'
							}
						},
					});
                }
            },
            addKit(){
                axios.post('/article',{design: "Yoh", qte: 120 , entrer: "2021-02-14"}).then((res) => {
                        this.getArticle().then(_=> {this.ref.dataTable().fnPageChange((this.table.page.info().pages) - 1);});
                    }
                ).catch(er => console.log(er.response.data.errors));
            },
            
            check(id){
                if(this.checkList.includes(id)){
                    const index = this.checkList.findIndex(i => i === id);
                    this.checkList.splice(index, 1);
                }else{
                    this.checkList.push(id);
                }
            },
            update(kit){
                this.errors.design = '';
                this.kit.id_a = kit.id_a;
                this.kit.design = kit.design;
                this.kit.Source = kit.id_s;
                this.select.val(kit.id_s).trigger('change');
            },
            async updateRow(kit){
                const index = this.kits.findIndex(i => i.id_a == kit.id_a);
                this.kits[index].design = kit.design;
                this.kits[index].id_s = kit.Source;
                this.kits[index].source = this.sources.filter(i => i.id_s == kit.Source)[0].source;
                //this.kits.splice(index, 1, kit);
            },
            save(){
                
                axios.put('/update_art',this.kit).then((res) => {
                    if(res.data){
                        //console.log(this.kit);
                        this.updateRow(this.kit);
                            this.kit.design = '';
                            this.select.val(0).trigger('change');
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
            repartir(){
                //console.log(this.checkList.length);
                if(this.checkList.length > 0){
                    this.$router.push({name: 'repartition', params: { list: this.checkList}});
                }else{
                    informer("Selectioner un élément svp !");
                }
            }
        }
    }
</script>
