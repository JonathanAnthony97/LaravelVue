<template>
    
    <div class="card">
        <div class="card-header">
            <span id="cardTitle" class="h4"><i class="fa fa-edit"></i>&nbsp;&nbsp;stocks</span>
            
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
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <fieldset class="border p-2">
                        <legend style="width: 9%;">&nbsp;Mise à jour</legend>
                        <div class="form-check" style="padding-top:5px">
                            <label class="form-radio-label">
                                <input class="form-radio-input" type="radio" v-model="picked" name="choix" :value="true">
                                <span class="form-radio-sign"><b>Dren</b></span>
                            </label>
                            <label class="form-radio-label ml-3">
                                <input class="form-radio-input" type="radio" v-model="picked" name="choix" :value="false">
                                <span class="form-radio-sign"><b>Cisco</b></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <button class="btn btn-xs addOn" data-toggle="modal" data-target="#exampleModal">
                                        Ajouter
                                    </button>
                            </label>
                        </div>
                        <div class="form-group" v-show="picked">
                            <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="mybasic"><b>Lieu</b></span>
                                    </div>
                                    <input type="text" value="DREN"
                                    style="background: white !important;color: #495057 !important; opacity: 1 !important;" 
                                    readonly="readonly" class="form-control">
                                </div>
                        </div>
                        <div class="form-group" v-show="!picked">
                            <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="mybasic"><b>Lieu</b></span>
                                    </div>
                                    <select class="form-control depot">
                                        <option v-for="c in ciscos" :value="c.id_cisco">{{ c.lieu_cisco }}</option>
                                    </select>
                                </div>
                            </div>
                        <div class="row" style="margin-top:5px;">
                            <div class="col-md-7" >
                                <div v-show="!change_field" class="form-group" >
                                    <label for="design"><b>Mise à jour Stock :</b></label>
                                    <div class="input-group" id="personal">
                                        <select class="form-control art_select" required data-placeholder="selectionner un article">
                                            <option value=""></option>
                                            <option v-for="opt in option" :value="opt.id_a">{{ opt.design }}</option>
                                        </select>
                                        <div class="input-group-prepend">
                                            <button class="btn btn-default btn-border" id="mybtn" @click="change_field = true"
                                                type="button"><i class="fas fa-sync-alt"></i></button>
                                        </div>
                                    </div>
                                    <small v-if="errors.id" class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>This field is required</small>
                                </div>
                                <div v-show="change_field" class="form-group">
                                    <label for="design"><b>Nouvel Article :</b></label>
                                    <div class="input-group" id="personal">
                                        <input @keydown="errors.design = null" type="text" class="form-control" id="design" v-model="article.design" placeholder="nom de l'article">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-default btn-border" @click="change_field = false"
                                                id="mybtn" type="button"><i class="fas fa-sync-alt"></i></button>
                                        </div>
                                    </div>
                                    <small v-for="er in errors.design" class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>{{ " "+er }}</small>
                                </div>
                            </div>
                            <div class="col-md-5" style="padding-left: 0px;">
                                <div class="form-group">
                                    <label for="design"><b>Source :</b></label>
                                        <select class="form-control source" data-placeholder="selectionner">
                                            <option></option>
                                            <option v-for="s in sources" :value="s.id_s">{{ s.source }}</option>
                                        </select>
                                    <small v-if="errors.src" class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>This field is required</small>
                                    </div>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:10px;">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="qte"><b>Quantite :</b></label>
                                    <input @keydown="errors.qte_entre = null" type="text" class="form-control" v-model="article.qte_entre" id="qte" placeholder="qte">
                                    <small v-for="er in errors.qte_entre" class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>{{ " "+er }}</small>
                                </div>
                            </div>
                            <div class="col-md-5" style="padding-left: 0px;">
                                <div class="form-group">
                                    <label for="datepicker"><b>Date reception :</b></label>
                                    <input type="text" class="form-control datepicker" id="datepicker" placeholder="jj-mm-aaaa">
                                    <small style="margin-top: 7px;" v-for="er in errors.date_entre"
                                    class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>{{ " "+er }}</small>
                                </div> 
                            </div>
                        </div>
                        
                    </fieldset>
                    
                </div>
            </div>
        </div>
        <div class="card-action" id="myFoot">
            <button class="btn btn-sm" style="background: #42b983;color:white"
                @click="submit"><b>Valider</b></button>&nbsp;
            <button class="btn btn-sm" @click="reset">Annuler</button>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i style="font-size:.9rem" class="fa fa-edit"></i> Ajout</h5>
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
                                            <span class="input-group-text" id="mybasic3"><b>Cisco :</b></span>
                                        </div>
                                        <input @keydown="errors.lieu_cisco = ''" type="text" v-model="cisco.lieu_cisco" placeholder="lieu" class="form-control modal-input">
                                    </div>
                                    <small v-for="er in errors.lieu_cisco" style="margin-top: 7px;" 
                                     class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i> {{ er }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="padding-right: 1.5rem;">
                        <button class="btn btm-sm modal-btn" @click="close" data-dismiss="modal">Close</button>
                        <button class="btn btm-sm modal-btn" style="background: #42b983 !important;color: #fff;" @click.prevent="add">Save</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
     
</template>

<script>
//import { required, minLength, between, minValue ,numeric } from 'vuelidate/lib/validators';
import { supression, supressionAll,reussie } from './../alert.js';
    export default {
        
        data(){
            return{
				article: { depot: null,src: null, id: null, design: '', qte_entre: '', date_entre: '' },
                option: [],
                ciscos: [],
                sources: [],
                errors: [],
                picked: true,
                change_field: true,
                picker : '',
                select1: '',
                select2: '',
                select3: '',
                cisco: { lieu_cisco: ''}
            }
        },
        mounted() {
            this.$root.$emit('activeLink','article');

            this.getCisco();
            this.getArticle();
            var select1 = $('.depot').select2({theme: 'bootstrap4'});
            var select2 = $('.art_select').select2({theme: 'bootstrap4'});
            var select3 = $('.source').select2({theme: 'bootstrap4'});

           
            //$('.datepicker').datepicker('destroy');
                $('.datepicker').datepicker('destroy');
                $('#datepicker').addClass('form-control datepicker');
            var picker = $('.datepicker').datepicker({
                locale: 'fr-fr',
                uiLibrary: 'bootstrap4',
                format: 'dd-mm-yyyy',
                value: this.article.entrer
            }).on("change",() => {
                this.article.date_entre = picker.value();
                this.errors.date_entre = null  
            });

            select1.on('change',() => { this.article.depot = select1.val();});
            select2.on('change',() => { this.article.id = select2.val();this.errors.id = null});
            select3.on('change',() => {this.article.src = select3.val();this.errors.src = null});
    
            this.select1 = select1;
            this.select2 = select2;
            this.select3 = select3;
            this.picker = picker;

        },
        watch: {
            picked: function(val){
                if(val){ this.article.depot = null;
                }else{
                    //this.select1.val(1).trigger('change');
                    this.article.depot = this.select1.val();
                    console.log(this.select1.val());
                }
            },
            change_field: function(val){
                this.errors.design = null;
                this.errors.id = null;
                if(val){ 
                    this.select2.val(0).trigger('change');
                    this.select3.prop("disabled", false);
                }else{
                    this.article.design = "";
                    this.select3.val(0).trigger('change');
                    this.select3.prop("disabled", true);
                }
            }
        },
        methods: {
            getArticle(){
                return axios.get('/getArticle').then( res => { this.option = res.data });  
            },
            getCisco(){
                return axios.get('/getlistCisco').then(res => { this.ciscos = res.data.ciscos;
                this.sources = res.data.sources;});
            },
            submit(){
                axios.post('/article',this.article).then((res) => {
                    if(res.data.id_a > 0){
                        console.log(res.data);
                        if(!this.article.id){
                            this.option.push({id_a: res.data.id_a, design: res.data.design});
                        }
                        reussie();
                        this.reset();
                    }
                }).catch((er) => {
                    if(er.response.status == 422){
                        this.errors = er.response.data.errors;
                        console.log(this.errors);
                    }
                });
            },
            reset(){
                this.errors = [];
                this.select2.val(0).trigger('change');
                this.select3.val(0).trigger('change');
                this.article.design = '';
                this.article.qte_entre = '';
                this.article.date_entre = '';
                this.picker.value("");
                
            },
            add(){
                axios.post('/add_cisco',this.cisco).then((res) => {
                    if(res.data){
                        this.ciscos.push(res.data);
                    }
                }).catch((er) => {
                    if(er.response.status == 422){
                        this.errors = er.response.data.errors;
                        //console.log(this.errors);
                    }
                });
            },
            close(){

            }
        }
    }
</script>

