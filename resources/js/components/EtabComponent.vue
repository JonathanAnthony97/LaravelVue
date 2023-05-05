<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span id="cardTitle" class="h4"><i class="fas fa-hockey-puck"></i>&nbsp;&nbsp;Etablissement</span>
                    
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
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                            <fieldset class="border p-2" style="margin-right: 18px;">
                                <legend style="width: 120px;">&nbsp;Ajout Etablissement</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="code"><b>Code :</b></label>
                                            <input type="text" v-model.trim="etab.code_etab" @keydown="errors.code_etab = null" class="form-control" id="code" placeholder="code ...">
                                            <small v-for="er in errors.code_etab"
                                                class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>{{ " "+er }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-6" style="padding-left: 0px;">
                                        <div class="form-group">
                                            <label for="zap"><b>Zap :</b>
                                                <button class="btn btn-xs addOn" data-toggle="modal" data-target="#exampleModal">
                                                    Ajouter
                                                </button>
                                            </label>
                                            <select class="form-control zap">
                                                <option v-for="z in zaps" :value="z.id_zap">{{ z.lieu_zap }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group" >
                                    <label for="design"><b>Nom Etablissement :</b></label>
                                    <input type="text"  v-model="etab.nom_etab" @keydown="errors.nom_etab = null" class="form-control" id="design" placeholder="designation">
                                    <small v-for="er in errors.nom_etab"
                                     class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>{{ " "+er }}
                                    </small>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="qte"><b>Niveau :</b></label>
                                            <select class="form-control niveau">
                                                <option value="EPP">EPP</option>
                                                <option value="CEG">CEG</option>
                                                <option value="LYCEE">LYCEE</option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-6" style="padding-left: 0px;margin-bottom:10px;">
                                        <div class="form-group" >
                                            <label for="ens"><b>Enseignant :</b></label>
                                            <input type="text" v-model.number="etab.enseignant" @keydown="errors.enseignant = null" class="form-control" id="ens" placeholder="Entier">
                                            <small v-for="er in errors.enseignant" class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>{{ " "+er }}</small>
                                        </div>
                                    </div>
                                    
                                </div> 
                            </fieldset>
                        </div>
                    
                        <div class="col-md-5" style="margin-left:0px;padding-left: 0px;">
                            <fieldset class="border p-2">
                                <legend style="width: 100px;">&nbsp;Effectifs Eleves</legend>
                                <div v-show="selected == 'EPP'">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="presco"><b>Préscolaire :</b></label>
                                                <input type="text" v-model.number="etab.classe.prescolaire" @keydown="errors['classe.prescolaire'] = null" class="form-control" id="presco" placeholder="Entier">
                                                <small v-for="er in errors['classe.prescolaire']"
                                                 class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>{{ " "+er }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="padding-left: 0px;">
                                            <div class="form-group">
                                                <label for="eff"><b>CP I - 11 ème :</b></label>
                                                <input type="text" v-model.number="etab.classe.cp1" @keydown="errors['classe.cp1'] = null" class="form-control" id="eff" placeholder="Entier">
                                                <small v-for="er in errors['classe.cp1']"
                                                 class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>{{ " "+er }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="presco"><b>CP II - 10 ème:</b></label>
                                                <input type="text" v-model.number="etab.classe.cp2" @keydown="errors['classe.cp2'] = null" class="form-control" id="presco" placeholder="Entier">
                                                <small v-for="er in errors['classe.cp2']"
                                                 class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>{{ " "+er }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="padding-left: 0px;">
                                            <div class="form-group">
                                                <label for="eff"><b>CM - 9 ème :</b></label>
                                                <input type="text" v-model.number="etab.classe.cm" @keydown="errors['classe.cm'] = null" class="form-control" id="eff" placeholder="Entier">
                                                <small v-for="er in errors['classe.cm']"
                                                 class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>{{ " "+er }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="presco"><b>CM I - 8 ème :</b></label>
                                                <input type="text" v-model.number="etab.classe.cm1" @keydown="errors['classe.cm1'] = null" class="form-control" id="presco" placeholder="Entier">
                                                <small v-for="er in errors['classe.cm1']"
                                                 class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>{{ " "+er }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="padding-left: 0px;">
                                            <div class="form-group" style="margin-bottom:10px;">
                                                <label for="eff"><b>CM II - 7 ème :</b></label>
                                                <input type="text" v-model.number="etab.classe.cm2" @keydown="errors['classe.cm2'] = null" class="form-control" id="eff" placeholder="Entier">
                                                <small v-for="er in errors['classe.cm2']"
                                                 class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>{{ " "+er }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div v-show="selected == 'CEG'">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="presco"><b>6 ème :</b></label>
                                                <input type="text" v-model.number="etab.classe.m6" @keydown="errors['classe.m6'] = null" class="form-control" id="presco" placeholder="Entier">
                                                <small v-for="er in errors['classe.m6']"
                                                 class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>{{ " "+er }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="padding-left: 0px;">
                                            <div class="form-group">
                                                <label for="eff"><b>5 ème :</b></label>
                                                <input type="text" v-model.number="etab.classe.m5" @keydown="errors['classe.m5'] = null" class="form-control" id="eff" placeholder="Entier">
                                                <small v-for="er in errors['classe.m5']"
                                                 class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>{{ " "+er }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="presco"><b>4 ème:</b></label>
                                                <input type="text" v-model.number="etab.classe.m4" @keydown="errors['classe.m4'] = null" class="form-control" id="presco" placeholder="Entier">
                                                <small v-for="er in errors['classe.m4']"
                                                 class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>{{ " "+er }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group" style="margin-bottom:10px;">
                                                <label for="eff"><b>3 ème :</b></label>
                                                <input type="text" v-model.number="etab.classe.m3" @keydown="errors['classe.m3'] = null" class="form-control" id="eff" placeholder="Entier">
                                                <small v-for="er in errors['classe.m3']"
                                                    class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>{{ " "+er }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div v-show="selected == 'LYCEE'">
                                    <div class="row">
                                        <div class="col-md-12">
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
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="eff"><b>Première :</b></label>
                                                <input type="text" v-model.number="etab.classe.premiere" @keydown="errors['classe.premiere'] = null" class="form-control" id="eff" placeholder="Entier">
                                                <small v-for="er in errors['classe.premiere']"
                                                 class="form-text text-danger">&nbsp;<i class="fas fa-info-circle"></i>{{ " "+er }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
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
                            </fieldset>
                        </div>
                        <!--{{ etab.classe }}-->
                    </div>
                    
                </div>
                <div class="card-action" id="myFoot">
                    <div class="row">
                        <div class="col-md-7">
                            <button class="btn btn-sm" style="background: #42b983;color:white" @click="save"><b>Enregistrer</b></button>&nbsp;
                            <button class="btn btn-sm" style="border:1px solid rgb(206, 212, 218) !important" @click="reset">Annuler</button>
                        </div>
                    </div>
                </div>
            </div>
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
                                        <select class="form-control modal-input cisco">
                                            <option v-for="opt in ciscos" :value="opt.id_cisco">{{ opt.lieu_cisco }}</option>
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="mybasic3"><b>Lieu :</b></span>
                                        </div>
                                        <input @keydown="errors.lieu_zap = ''" type="text" v-model.trim="zap.lieu_zap" placeholder="lieu" class="form-control modal-input">
                                    </div>
                                    <small v-for="er in errors.lieu_zap" style="margin-top: 7px;" 
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
import { supression, supressionAll,reussie,informer } from './../alert.js';
    export default {
        data(){
            return{
                zaps : [], ciscos: [], selected: 'EPP',
                errors: [], select1: '', select2: '',select5: '',
                etab: { code_etab: '', zap: '', nom_etab : '', niveau: '', enseignant: '', classe: {}},
                zap: { lieu_zap: '', id_cisco: ''}
            }
        },
        mounted() {
            this.$root.$emit('activeLink','etab');
            this.getZap();
            //this.getEtab();
            this.getCisco();
            this.complete('EPP');
            var select1 = $('.zap').select2({theme: 'bootstrap4'}).on('change',() => {
                this.etab.zap = select1.val();
            });
            var select2 = $('.niveau').select2({theme: 'bootstrap4'}).on('change',() => {
                this.etab.niveau = select2.val();
                this.selected = select2.val();
                this.complete(select2.val());
            });


            var select5 = $('.cisco').select2({theme: 'bootstrap4',dropdownParent: $('#exampleModal')}).on('change',() => {
                this.zap.id_cisco = select5.val();
            });
         
            this.select1 = select1;this.select2 = select2;
            this.select5 = select5;

            //this.select1.val(2).trigger('change');
        },
        methods: {
            getZap(){
                axios.get('/getzap').then(res => { this.zaps = res.data;  });
            },
            getCisco(){
                return axios.get('/getlistCisco').then(res => { this.ciscos = res.data.ciscos});
            },
            complete(niv){
                this.etab.classe = {};
                switch(niv){
                    case 'EPP':
                        this.etab.classe.prescolaire = '';
                        this.etab.classe.cp1 = '';
                        this.etab.classe.cp2 = '';
                        this.etab.classe.cm = '';
                        this.etab.classe.cm1 = '';
                        this.etab.classe.cm2 = '';
                        break;
                    case 'CEG':
                        this.etab.classe.m6 = '';
                        this.etab.classe.m5 = '';
                        this.etab.classe.m4 = '';
                        this.etab.classe.m3 = '';
                        break;
                    case 'LYCEE':
                        this.etab.classe.seconde = '';
                        this.etab.classe.premiere = '';
                        this.etab.classe.terminale = '';
                        break;
                }
            },
            /*getEtab(){
                this.etabs = [];
                axios.get('/getEtab').then(res => { this.etabs = res.data;});
            },
            /*getClasse(){
                this.classes = [];
                const niv = this.etabs.filter(i => i.id_etab == this.select3.val())[0].niveau;
                //console.log(niv);
                axios.get('/get_nomClasse/'+niv).then(res => { this.classes = res.data });
            },
            getEffectif(nom_cls){
                if(this.select3.val() > 0){
                    const data = {nom_cls: nom_cls, id_etab: this.select3.val() };
                    axios.post('/getEffectif',data).then(res => this.classe.effectif = res.data);
                }
            },*/
            add(){
                this.zap.id_cisco = this.select5.val();
                
                axios.post('/create_zap',this.zap).then((res) =>{
                    if(res.data){
                        //const z = { id_zap: res.data.id_zap, lieu_zap: res.data.lieu_zap};
                        this.zaps.push(res.data);
                        this.zap.lieu_zap = '';
                        $('#exampleModal').modal('hide');
                        reussie();
                        //console.log(z);
                    }
                }).catch((er) => {
                    if(er.response.status == 422){
                        this.errors = er.response.data.errors;
                        console.log(this.errors);
                    }
                });
            },
            close(){
                this.zap.lieu_zap = '';
                this.errors.lieu_zap = '';
            },
            reset(){
                this.errors = [];
                this.etab.code_etab = '';
                this.etab.nom_etab = '';
                this.etab.enseignant = '';
                this.complete(this.select2.val());
            },
            save(){
                this.etab.zap = this.select1.val();
                this.etab.niveau = this.select2.val();
                axios.post('/create_etab',this.etab).then((res) => {
                    if(res.data){
                        console.log(res.data);
                        //this.etabs.push(res.data);
                        this.reset();
                        reussie();
                    }
                }).catch((er) => {
                    if(er.response.status == 422){
                        this.errors = er.response.data.errors;
                        console.log(this.errors);
                    }
                });
            },
            submit(){
                if(this.select3.val() && this.select4.val()){
                    axios.post('/create_classe',this.classe).then((res) => {
                        if(res.data){
                            //this.classe.effectif = '';
                            reussie();
                            
                        }
                    }).catch((er) => {
                        if(er.response.status == 422){
                            this.errors = er.response.data.errors;
                            console.log(this.errors);
                        }
                    });
                }else{
                    informer('Veuillez bien renseigner la formulaire !')
                }
                
            }
            
        }
    }
</script>

