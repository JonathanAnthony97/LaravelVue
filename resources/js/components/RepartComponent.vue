<template>
    <div class="row">
        <div class="col-12">
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
                </div>
                <div class="card-body" id="myDiv">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group" style="padding:0px !important;margin-left: 15px;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="mybasic"><b>Cisco</b></span>
                                    </div>
                                    <select class="form-control depot">
                                        <option v-for="c in ciscos" :value="c.id_cisco">{{ c.lieu_cisco }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" :class="errors.date ? 'has-error' : ''" style="padding:0px !important;"> 
                                <input type="text" class="form-control datepicker"
                                 id="datepicker" placeholder="date (dd-mm-yy)">
                                <small v-for="er in errors.date" style="margin-top: 7px;margin-left: 3px;" class="form-text text-danger">
                                    <i class="fas fa-info-circle"></i>&nbsp;{{er}}</small>
                            </div>
                        </div>
                        <div class="col-md-3" style="margin-top: 4px;">
                            <button class="btn btn-sm" style="border:1px solid #ced4da !important; margin-right: 15px;" @click="toPdf"><i class="fas fa-file-pdf"></i>&nbsp; PDF</button>
                            <button class="btn btn-sm" style="border:1px solid #ced4da !important;margin-right: 15px;" @click="repartir">Valider</button>
                            <button class="btn btn-sm" style="border:1px solid #ced4da !important; " @click="retour"><i class="la flaticon-back"></i></button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 anime fadeIn" style="margin-top: 25px;">
                            <!--{{ this.done }}-->
                            <table class="display table table-bordered" id="tabRepart">
                                <thead>
                                    <tr>
                                        <th class="no-sort" style="width: 4%;text-align: center;">#</th>
                                        <th >Article</th>
                                        <th >Categorie</th>
                                        <th >En Stock (Dren)</th>
                                        <th >Quantité sortie</th>
                                        <th style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <tr v-for="(kit, index) in done.article" :key="kit.id_a" :id="kit.id_a">
                                        <td style="text-align: center;"><b>{{ index + 1 }}</b></td>
                                        <td>{{ kit.design }}</td>
                                        <td>{{ kit.source }}</td>
                                        <td>{{ kit.qte_st | splitNumber }}</td>
                                        <td style="width: 35%;">
                                            <div class="form-group form-inline"
                                             :class="errors[`article.${index}.sortie`] ? 'has-error' : ''" id="myPersonal">
                                                <input @keydown="errors[`article.${index}.sortie`] = null" type="text"  v-model.number="kit.sortie" class="form-control myPersonal" placeholder="entier">
                                                <small v-for="(er, i) in errors[`article.${index}.sortie`]"
                                                 style="margin: 0px;" class="form-text text-danger">
                                                 <i style="margin-left: 10px !important;margin-right: 3px;" class="fas fa-info-circle"></i>{{ er}}</small>
                                            </div>
                                        </td>
                                        <td style="width: 5%;">
                                            <button id="action3" type="button" @click="remove(kit.id_a)" class="btn btn-sm btn-link" >
                                                <span id="bob">Annuler</span>
                                            </button>
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
    import { supression, supressionAll,reussie } from './../alert.js';
    export default {
        data(){
            return{
                ref: '',
                table: '',
                ciscos: [],
                errors: [],
                select1: '',
                picker: '',
                list: [],
                done: { cisco: '', article: [], date: ''}
            }
        },
        mounted() {
            this.$root.$emit('activeLink','article');
            this.ref = $('#tabRepart');

            this.getCisco();
            var select1 = $('.depot').select2({theme: 'bootstrap4'});
    
            //var select2 = 
                select1.on('change',() => { this.done.cisco = select1.val();});

                $('.datepicker').datepicker('destroy');
                $('#datepicker').addClass('form-control datepicker');
            var picker = $('.datepicker').datepicker({
                locale: 'fr-fr',
                uiLibrary: 'bootstrap4',
                format: 'dd-mm-yyyy',
                value: this.today()
            }).on("change",() => {
                this.errors.date = '';
                this.done.date = picker.value();
            });
                this.select1 = select1;
                this.picker = picker;
                if(this.$route.params.list){
                    this.list = this.$route.params.list;
                    this.getData();
                }else{
                    this.activeDataTable();
                }
                


        },
        methods: {
            today(){
                const date = new Date();
                const d = (date.getDate() < 10) ? '0' + date.getDate() : date.getDate();
                const m = (date.getMonth() < 10) ? '0' + date.getMonth() : date.getMonth();
                return d + '-' + m + '-' + date.getFullYear();
            },
            activeDataTable(){
                this.$nextTick(() => {
                    this.table = this.ref.DataTable({
                	"pageLength": 5,
                    
				    });
                });
			},
            getCisco(){
                return axios.get('/getlistCisco').then(res => { this.ciscos = res.data.ciscos});
            },
            getData(){
                if(this.list.length > 0){
                    return axios.post('/getData',{data: this.list}).then(
                    res => {
                        this.done.article = res.data;
                        if ($.fn.DataTable.isDataTable('#tabRepart')) {this.table.destroy();}
                        this.activeDataTable();
                        console.log(res.data);
                    });
                }
            },
            remove(id){
                this.done.article = this.done.article.filter(i => i.id_a != id);
                this.table.rows('#'+id).remove().draw(false);
                const index = this.list.findIndex(i => i === id);
                this.list.splice(index, 1);
            },
            repartir(){
                this.done.cisco = this.select1.val();
                this.done.date = this.picker.value();
                
                if(this.done.article.length > 0){
                    axios.post('/repartir',this.done).then((res) => {
                        if(res.data > 0){
                            //console.log(res.data);
                            //this.done.article = [];//////////////////////////////////
                            //this.list = [];
                            //this.table.clear().draw();
                            this.getData();
                            reussie();
                        }
                    }).catch((er) => {
                        if(er.response.status == 422){
                            this.errors = er.response.data.errors;
                            //console.log(this.errors);
                        }
                    });
                }
            },
            toPdf(){
                this.done.cisco = this.select1.val();
                this.done.date = this.picker.value();
                
                if(this.done.article.length > 0){
                    axios.post('/repartir_pdf',this.done).then((res) => {
                    }).catch((er) => {
                        if(er.response.status == 422){
                            this.errors = er.response.data.errors;
                            //console.log(this.errors);
                        }
                    });
                }
            },
            retour(){ 
               this.$router.push({name: 'homepage', params: { list: this.list}});
            }
        }

    }
</script>