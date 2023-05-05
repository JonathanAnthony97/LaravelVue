<template>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group" style="padding:0px !important;margin-left: 15px;">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="mybasic"><b>Cisco</b></span>
                            </div>
                            <select class="form-control form-control-sm cisco" data-placeholder="selectionner">
                                
                                <option v-for="c in ciscos" :value="c.id_cisco">{{ c.lieu_cisco }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3" style="margin-top: 4px;">
                    <button class="btn btn-sm" @click="valider" style="border:1px solid #ced4da !important;margin-right: 15px;">Distribuer</button>     
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="margin-top: 22px;">
                <div class="table-responsive anime fadeIn">
                    <table id="histoTable" class="display table table-striped table-bordered">
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
                                <th style="width: 10%">Action</th>
                            </tr>
                        </thead>
                        
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
                                        <button id="action" type="button" @click="goto" class="btn btn-link">
                                            <i class="fa fa-edit"></i><span id="bob">Modifier</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                   <!--{{ ciscos }} {{ this.$route.params.cisco }}-->
                </div>
            </div>  
        </div>
              
     </div>
</template>

<script>
import { supression, supressionAll, informer } from './../alert.js';
    export default {
        data() {
            return{
                ref: '',table: '',ciscos: [] ,kits: [], test: [],
                select1: '',checkAll: false,checkList: [],
                done: { lieu: '',cisco: '', kits: [] }
            }
        },
        mounted() {
            this.$root.$emit('activeLink','dist');
            this.ref = $('#histoTable');
            
            var select1 = $('.cisco').select2({theme: 'bootstrap4'}).on('change',() => {
                this.done.cisco = select1.val();
                this.getStock(this.done.cisco);
            });
            this.select1 = select1;
            
            if(this.$route.params.cisco){
                this.done.cisco = this.$route.params.cisco;
                this.reorder(this.done.cisco);
                this.getStock(this.done.cisco);
                this.checkList = this.$route.params.list;
                
            }else{
                this.getCisco();
                this.getStock(1);
            }
            this.activeDataTable();
            
        },
        watch: {
            checkAll : function(val){
                this.react(val);
            }
        },
        methods:{
            getCisco(){
                return axios.get('/getlistCisco').then(res => { this.ciscos = res.data.ciscos});
            },
            reorder(id){
                return axios.get('/getCisco/'+id).then(res => { this.ciscos = res.data;});
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
            getStock(id = ''){
                //console.log(id);
                return axios.get('/stock_repart/'+id)
                .then(
                    res => {
                        this.kits = res.data;
						//console.log(this.kits);
                        if ($.fn.DataTable.isDataTable('#histoTable')) {this.table.destroy();}
                        this.activeDataTable();
                    }
                ).catch(error => console.log(error));
            },
            react(val){
                this.checkList = [];
                if(val){
                    for(let i=0; i< this.kits.length;i++){
                        this.checkList.push(this.kits[i].id_a);
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
            valider(){
                this.done.cisco = this.select1.val();
                this.done.lieu = this.ciscos.filter(i => i.id_cisco == this.select1.val())[0].lieu_cisco;
                if(this.checkList.length > 0){
                    axios.post('/getSelected',{data: this.checkList,id: this.done.cisco}).then(res =>{
                        //console.log(res.data);
                        this.done.kits = res.data;
                        this.$router.push({name: 'distribution', params: { data: this.done,list: this.checkList}});
                    });
                    
                }else{
                    informer("Selectioner un élément svp !");
                }
            },
            goto(){
                this.$router.push('/addkit');
            }
            
        }
    }
</script>