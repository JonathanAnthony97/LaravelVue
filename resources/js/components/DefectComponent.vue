<template>
    
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
        <div class="card-body">
            <div class="row">
                <div class="col-md-9"> 
                    <fieldset class="border p-2">
                        <legend style="width: 10%;">&nbsp;Ajout article</legend>
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
                    
                        <div class="form-group" style="margin-top:4.65px;">
                            <label for="design"><b>Designation :</b></label>
                                <select class="form-control art_select" required data-placeholder="selectionner un article">
                                    <option value=""></option>
                                    <option v-for="opt in option" :value="opt.id_a">{{ opt.design }}</option>
                                </select>
                            
                            <small v-if="errors.id" class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>This field is required</small>
                        </div>
                        <div class="form-group" style="margin-top:1.83px;margin-bottom:10px;">
                            <label for="qte"><b>Quantite :</b></label>
                            <input @keydown="errors.qte_entre = null" type="text" class="form-control" v-model="article.qte_entre" id="qte" placeholder="qte">
                            <small v-for="er in errors.qte_entre" class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>{{ " "+er }}</small>
                        </div>
                    </fieldset>
                </div>
                
            </div>
        </div>
        <div class="card-action" id="myFoot">
            
            <button class="btn btn-sm" style="background: #42b983;color:white" @click="submit"><b>Submit</b></button>&nbsp;
            <button class="btn btn-sm" @click="reset">Cancel</button>
                
        </div>
    </div>
        
</template>

<script>
    
    import { supression, supressionAll,reussie } from './../alert.js';
    export default {
        
        data(){
            return{
				article: { depot: null, id: null, qte_entre: ''},
                option: [],
                ciscos: [],
               
                errors: [],
                picked: true,
                
                select1: '',
                select2: ''
               
            }
        },
        mounted() {
            this.$root.$emit('activeLink','article');

            this.getCisco();
            this.getArticle();
            var select1 = $('.depot').select2({theme: 'bootstrap4'});
            var select2 = $('.art_select').select2({theme: 'bootstrap4'});
            select1.on('change',() => { this.article.depot = select1.val(); this.getArticle(this.article.depot)});
            select2.on('change',() => { this.article.id = select2.val();this.errors.id = null});
        
            this.select1 = select1;
            this.select2 = select2;
        },
        watch: {
            picked: function(val){
                if(val){ this.article.depot = null;
                    this.getArticle();
                    this.select2.val(0).trigger('change');
                }else{
                    //this.select1.val(1).trigger('change');
                    this.article.depot = this.select1.val();
                    this.getArticle(this.article.depot);
                    this.select2.val(0).trigger('change');
                    console.log(this.select1.val());
                }
            }
        },
        methods: {
            getArticle(id = ""){
                this.option = '';
                return axios.get('/getArticle_Dren/'+id).then( res => { this.option = res.data });  
            },
            getCisco(){
                return axios.get('/getlistCisco').then(res => { this.ciscos = res.data.ciscos;});
            },
            submit(){
                axios.post('/article_def',this.article).then((res) => {
                        if(res.data > 0){
                            console.log(res.data);
                            reussie();
                            this.reset();
                        }
                    }
                ).catch((er) => {
                    if(er.response.status == 422){
                        this.errors = er.response.data.errors;
                        console.log(this.errors);
                    }
                });
            },
            reset(){
                this.errors = [];
                this.select2.val(0).trigger('change');
                this.article.design = '';
                this.article.qte_entre = '';
            }
        }
    }
</script>

