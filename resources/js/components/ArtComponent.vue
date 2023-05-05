<template>
    <div class="row">
        <div class="col-md-10" style="padding-right: 0px;">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group" style="padding-top:0px !important;">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="mybasic"><b>Cisco</b></span>
                            </div>
                            <input type="text" class="form-control readon" v-model="done.lieu" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" style="padding:0px !important;">
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
                <div class="col-md-4">
                    <div class="form-group" :class="errors.date_dist ? 'has-error' : ''" style="padding:0px !important;margin-right: 15px;"> 
                        <input type="text" class="form-control datepicker"
                         id="datepicker" placeholder="jj-mm-aaaa">
                        <small v-for="er in errors.date_dist" style="margin-top: 7px;margin-left: 3px;" class="form-text text-danger">
                            <i class="fas fa-info-circle"></i>&nbsp;{{er}}</small>
                    </div>
                </div>
                
            </div>
            <div class="row">
                <div class="col-md-12" style="margin-top: 22px;">
                    <div class="table-responsive">
                        <table id="histoTable" class="display table table-bordered">
                            <thead>
                                <tr>
                                    <th class="no-sort" style="width: 3%;text-align: center;">#</th>
                                    <th>Designation</th>
                                    <th>Stock</th>
                                    <th>Unité Dist</th>
                                    <th>Effectifs Bénef</th>
                                    <th>Qté Dist</th>
                                    
                                </tr>
                            </thead>
                            
                            <tbody>
                                <tr v-for="(kit, index) in done.kits" :key="kit.id_a" :id="kit.id_a">
                                    <td style="text-align: center;"><b>{{ index + 1 }}</b></td>
                                    <td>{{ kit.design }}</td>
                                    <td style="width: 9%;">{{ kit.qte_st | splitNumber }}</td>
                                    
                                    <td style="width: 19%">
                                        <div class="form-group form-inline"
                                        :class="errors[`kits.${index}.unite_dist`] ? 'has-error' : ''" id="myPersonal">
                                            <input type="text" :style="{width: errors[`kits.${index}.unite_dist`] ? '70px' : ''}"
                                             @keyup="calculate(kit.unite_dist,index)"  @keydown="errors[`kits.${index}.unite_dist`] = null" 
                                              v-model.number="kit.unite_dist" class="form-control myPersonal2" placeholder="entier">
                                              <small v-for="(er, i) in errors[`kits.${index}.unite_dist`]"
                                              style="margin: 0px;" class="form-text text-danger">
                                                <i style="margin-left: 7px !important;margin-right: 2px;"
                                                 class="fas fa-info-circle"></i> {{ er }}
                                            </small>
                                        </div>
                                    </td>
                                    <td style="width: 19%;">
                                        <div class="form-group form-inline" :class=" errors.eff ? 'has-error' : ''" id="myPersonal">
                                            <input type="text" :readonly="isReadOnly" :style="{width: errors.eff ? '70px' : ''}"
                                            @keydown="errors.eff = null" @keyup="calculate2"
                                              v-model="done.eff" class="form-control myPersonal2" placeholder="entier">
                                            <small v-for="(er, i) in errors.eff"
                                             style="margin: 0px;" class="form-text text-danger">
                                                <i style="margin-left: 7px !important;margin-right: 2px;"
                                                 class="fas fa-info-circle"></i> {{ er }} 
                                            </small>
                                        </div>
                                    </td>
                                    <td style="width: 19%;">
                                        <div class="form-group form-inline" 
                                        :class="errors[`kits.${index}.qte_dist`] ? 'has-error' : ''" id="myPersonal">
                                            <input type="text" readonly="readonly"
                                             :style="{width: errors[`kits.${index}.qte_dist`] ? '70px' : ''}"
                                              v-model="(kit.qte_dist == 0) ? '---': kit.qte_dist " class="form-control myPersonal2" placeholder="Qte Dist">
                                            <small v-for="(er, i) in errors[`kits.${index}.qte_dist`]"
                                             style="margin: 0px;" class="form-text text-danger">
                                                <i style="margin-left: 7px !important;margin-right: 2px;"
                                                 class="fas fa-info-circle"></i> {{ er }} 
                                            </small>
                                        </div>
                                    </td>        
                                </tr>
                            </tbody>
                        </table>
                    </div>
                      
                   <!--{{ checkList }} <!-{{ done }}  {{ checkList }}-->
                </div>
            </div>  
        </div>
        <div class="col-md-2" style="padding-right: 0px;padding-left: 0px;">
            <div class="form-group" style="padding-top:0px !important;margin-top: 6px;">
                <button class="btn btn-sm" style="border:1px solid #ced4da !important;" @click="retour"><i class="la flaticon-back"></i></button>
                &nbsp;&nbsp;&nbsp;<button class="btn btn-sm" style="background: #42b983;color:white"
                    @click="Submit"><b>Valider</b></button>
                &nbsp;&nbsp;&nbsp;<button class="btn btn-sm" style="border:1px solid #ced4da !important;" @click="cancel">Annuler</button>
            </div>
            
            <div class="form-group" style="margin-top: 24px;">
                <label for="design"><b>Etablissement :</b></label>
                <select class="form-control etab" data-placeholder="selectionner">
                    <option value=""></option>
                    <option v-for="e in etabs" :value="e.id_etab">{{ e.niveau +' - '+e.nom_etab }}</option>
                </select>
            </div>

            <div class="form-group" >
                <label for="design"><b>Bénéficiaire :</b></label>
                <select class="form-control benef" data-placeholder="selectionner">
                    <option value="El">Elève</option>
                    <option value="En">Enseignant</option>
                    <option value="Et">Etablissement</option>
                </select>
            </div>
        
            <div class="form-group">
                <label for="design"><b>Classe :</b></label>
                <select class="form-control classe" data-placeholder="selectionner" >
                    <option value=""></option>
                    <option v-for="c in classes" :value="c.id_cls">{{ c.nom_cls }}</option>
                </select>
            </div>
            <!--div class="form-group" style="margin-top: 29px;">
                <button class="btn btn-sm" style="background: #42b983;color:white"
                    @click="Submit"><b>Submit</b></button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-sm" @click="cancel">Cancel</button>
            </div-->

            

        </div>       
     </div>
</template>

<script>
import { supression, supressionAll, reussie, informer } from './../alert.js';
    export default {
        data() {
            return{
                ref: '',table: '',errors: [],
                zaps: [],etabs: [],classes: [],isReadOnly: true,
                lieu: '', select2: '',select3: '',select4: '',select5: '',
                checkAll: false, checkList: [], picker: '', HasError: false,
                done: { kits: [], cisco: '', date_dist: '', zap: '', etab: '',benef: '', eff: '', classe: '' }
            }
        },
        mounted() {
            this.$root.$emit('activeLink','dist');
            this.ref = $('#histoTable');
            if(this.$route.params.data){
                this.done.lieu = this.$route.params.data.lieu;
                this.done.kits = this.$route.params.data.kits;
                this.checkList = this.$route.params.list;
                this.done.cisco = this.$route.params.data.cisco;
                this.getZap(this.done.cisco);
            }
            
            this.activeDataTable();
            
            //this.getEtab(1);
            //this.getClasse(1);

            $('.datepicker').datepicker('destroy');
            $('#datepicker').addClass('form-control datepicker'); 
            var picker = $('.datepicker').datepicker({
                locale: 'fr-fr',
                uiLibrary: 'bootstrap4',
                format: 'dd-mm-yyyy',
                value: ''
            }).on("change",() => {
                this.done.date_dist = picker.value();
                this.errors.date_dist = '';
            });
            this.picker = picker;

            
            //this.zaps = ''; this.etabs = ''; this.classes = '';this.getZap(select1.val());

            
            var select2 = $('.zap').select2({theme: 'bootstrap4'}).on('change',() => {
                this.done.zap = select2.val();this.getEtab(select2.val());
            });
            var select3 = $('.etab').select2({theme: 'bootstrap4'}).on('change',() => { 
                this.done.etab = select3.val();
                this.getClasse(select3.val()); 
                this.getEffect(this.done.etab);
            });
            var select4 = $('.benef').select2({theme: 'bootstrap4'}).on('change',() => { 
                this.done.benef = select4.val(); this.onSelectBenef(select4.val());                
            });
            var select5 = $('.classe').select2({theme: 'bootstrap4'}).on('change',() => {
                this.done.classe = select5.val();
                this.done.eff = (select5.val() > 0) ? this.getEffectif(select5.val()) : '';
                this.calculate2();
            });
            
            this.select2 = select2;this.select3 = select3;
            this.select4 = select4;this.select5 = select5

        
        },
        watch: {
            checkAll : function(val){
                this.react(val);
            }
        },
        methods:{
            today(){
                const date = new Date();
                const d = (date.getDate() < 10) ? '0' + date.getDate() : date.getDate();
                const m = (date.getMonth() < 10) ? '0' + date.getMonth() : date.getMonth();
                return d + '-' + m + '-' + date.getFullYear();
            },
            getEffect(id){
                this.done.eff = ''; this.isReadOnly = false;
                if(id > 0){
                    if(this.select4.val() == 'En'){
                        this.done.eff = this.getEffectEns(id);
                    }
                    if(this.select4.val() == 'Et'){
                        this.isReadOnly = true;
                        
                        this.done.eff = '1';
                    }
                }
            },
            getEffectif(id){
                this.errors.eff = '';
                
                const c = this.classes.filter(i => i.id_cls == id);
                return c[0].eff_el;
            },
            getEffectEns(id){
                const c = this.etabs.filter(i => i.id_etab == id);
                return c[0].eff_ens;
            },
            getZap(id){
                this.zaps = [];
                return axios.get('/getzap/'+id).then(res => { this.zaps = res.data});
            },
            getEtab(id){
                this.etabs = [];
                return axios.get('/getetab/'+id).then(res => { this.etabs = res.data});
            },
            getClasse(id){
                this.classes = [];
                return axios.get('/getclasse/'+id).then(res => { this.classes = res.data});
            },
            onSelectBenef(val){
                this.isReadOnly = false;
                this.errors.eff = null;
                if(val == 'El'){
                    this.select5.prop("disabled", false);
                    this.done.eff = '';
                    for(let i = 0 ;i < this.done.kits.length; i++){
                        this.done.kits[i].qte_dist = 0;
                    }
                }else{
                    this.select5.prop("disabled", true);
                    this.select5.val(0).trigger('change');
                    this.done.classe = '';
                    this.done.eff = '';
                    if(this.select3.val() > 0){
                        if(val == 'En'){
                            this.done.eff = this.getEffectEns(this.select3.val());
                        }else{
                            this.isReadOnly = true;
                            this.done.eff = '1';
                        }
                    this.calculate2();
                    }
                }
            },
            remove(id){
                this.done.kits = this.done.kits.filter(i => i.id_a != id);
                this.table.rows('#'+id).remove().draw(false);
                const index = this.checkList.findIndex(i => i === id);
                this.checkList.splice(index, 1);
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
            retour(){
                this.$router.push({name: 'selection', params: { cisco: this.done.cisco,list: this.checkList}});
            },
            deleteAll(){
                if(this.checkList.length > 0){
                    supressionAll(this.checkList,'/del_reparts').then((res) => {
                        if(res){
                            //this.getHisto(select1.val());
                            this.kits = this.kits.filter(i => !this.checkList.includes(i.id_a));
                            this.checkList.forEach(id => {
                                this.table.rows('#'+id).remove().draw(false);
                            });
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
            calculate(unite,index){
                this.errors[`kits.${index}.qte_dist`] = '';
                this.done.kits[index].qte_dist = (unite > 0 && this.done.eff > 0) ? unite * this.done.eff : 0;
            },
            calculate2(){
                for(let i=0; i < this.done.kits.length; i++){
                    this.errors[`kits.${i}.qte_dist`] = '';
                    const unite = this.done.kits[i].unite_dist;
                    this.done.kits[i].qte_dist = ( unite > 0 && this.done.eff > 0) ? unite * this.done.eff : 0;
                }
                //const unite = this.done.kits[index].unite_dist;   
            },
            Submit(){
                this.done.benef = this.select4.val();
                this.done.date_dist = this.picker.value();
               
                if(this.select2.val() && this.select3.val()){
                   if(this.checkList.length > 0){
                        axios.post('/distribuer',this.done).then((res) =>{
                            if(res.data){
                                //console.log(res.data);
                                this.checkList = [];
                                this.table.clear().draw();
                                reussie();
                            }
                        }).catch((er) => {
                            if(er.response.status == 422){
                                this.errors = er.response.data.errors;
                                //console.log(this.errors);
                            }
                        });
                    }else{ informer("Selectionner l'article à distribuer !"); }
                }else{
                    informer("Selectionner un etablissement svp !");
                }
            },
            cancel(){
                this.errors = [];
                for(let i=0; i < this.done.kits.length; i++){
                    
                    const unite = this.done.kits[i].unite_dist;
                    this.done.eff = '';
                    this.done.kits[i].unite_dist = '';
                    this.done.kits[i].qte_dist = 0;
                }
                
            }
        }
    }
</script>