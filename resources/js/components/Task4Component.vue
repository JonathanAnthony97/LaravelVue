<template>
    <div class="row anime fadeIn">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" id="myHeader">
                    <div class="d-flex align-items-center">
                    
                        <span id="cardTitle" class="h4"><i class="fas fa-hockey-puck"></i>&nbsp;&nbsp;Articles</span>
                        
                        <router-link to="/" style="background: #42b983;color:white" class="btn btn-xs  ml-auto">
                            <i class="fa fa-plus"></i>
                            <b>Add</b>
                        </router-link>
                        &nbsp;&nbsp;
                        <div class="btn-group dropdown">
                            <button class="btn btn-info btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                               <i class="fa fa-cog"></i>&nbsp;<b>Action</b>&nbsp;
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right"  role="menu" aria-labelledby="dropdownMenu">
                                <a class="dropdown-item mydrop" href="#">Sortie</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item mydrop" @click="deleteAll" href="#">Delete</a>
                                
                                
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic" class="display table table-striped table-bordered" >
                            <thead>
                                <tr>
                                    <th class="no-sort" @click.self="checkAll = checkAll ? false : true ">
                                        <label class="check-container">
                                            <input type="checkbox" v-model="checkAll">
                                            <span class="checkmark"></span>
                                        </label>
                                    </th>
                                    
                                    <th>Design</th>
                                    <th>Quantite</th>
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
                                    <th>Design</th>
                                    <th>Quantite</th>
                                    <th>Date</th>
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
                                    <td>{{ kit.qte }}</td>
                                    <td>{{ kit.entrer }}</td>
                                    <td>
                                        <div class="form-button-action">
                                            <button id="action" type="button" class="btn btn-link" >
                                                <i class="fa fa-edit"></i><span id="bob">Edit</span>
                                            </button>
                                            <button @click="deleteKit(kit.id_a)" id="action2" type="button" class="btn btn-link">
                                                    <i class="fa fa-trash"></i><span id="bob">Delete</span>
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
        <div class="col-md-2">

        

        {{  checkAll }}
        <br>
            <button class="btn bt-default" @click="addKit">add</button>
            <button class="btn bt-info" @click="update">update</button>
            </br>
            <span>Item cochés : {{ checkList }}</span>
        </div>     
	</div>
</template>

<script>
    import { supression, supressionAll } from './../alert.js';
    export default {
        data: function(){
            return{
				ref: '',
				table: '',
                checkAll: false,
                checkList: [],
                kits: null
            }
        },
        mounted() {
            this.$root.$emit('activeLink','lien2');
            this.$root.$emit('subLink','task4');
            this.ref = $('#basic');
            
            //liste
            this.getArticle(); 
        },
        watch: {
            checkAll : function(val){
                this.react(val);
            }
        },
        methods: {
			activeDataTable(){
                this.$nextTick(() => {
                    this.table = this.ref.DataTable({
                	"pageLength": 6,
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
                        if ($.fn.DataTable.isDataTable('#basic')) {this.table.destroy();}
                        this.activeDataTable();
                    }
                ).catch(error => console.log(error));
            },
            deleteKit(id){
                supression('/article/'+id).then((res) => {
                    if(res){
                        this.kits = this.kits.filter(i => i.id_a != id);
                        this.table.rows('#'+id).remove().draw(false);
                        const index = this.checkList.findIndex(i => i.id_a === id);
                        this.checkList.splice(index, 1);
                    }
                });
            },
            deleteAll(){
                if(this.checkList.length > 0){
                    supressionAll(this.checkList).then((res) => {
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
            update(){
                const kit = {id_a: 400, design: "updated", qte: 66 , entrer: "2021-02-14"};
                const index = this.kits.findIndex(i => i.id_a === 400);
                this.kits.splice(index, 1, kit);
                console.log(this.kits);
            },
            check(id){
                if(this.checkList.includes(id)){
                    const index = this.checkList.findIndex(i => i.id_a === id);
                    this.checkList.splice(index, 1);
                }else{
                    this.checkList.push(id);
                }
            }
        }
    }
</script>
