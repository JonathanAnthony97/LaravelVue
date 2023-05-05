<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\DistRequest;
use App\Article;
use App\Stock;
use App\Cisco;
use App\Zap;
use App\Etablissement;
use App\Classe;
use App\Source;
use App\Entre; 
use App\Defectueu;
use App\Repartition;
use App\Distribution;
use App\Dist_class;
use App\Dist_etab;
use Carbon\Carbon;

class DistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function updateArt(Request $request){
        $eror = request()->validate([
            'design' => 'required|unique:articles|min:3'
        ]);
        $res = Article::where('id_a',$request->id_a)->update(['design'=> $request->design,'id_s' => $request->Source]);
        return $res;
    }

    public function getzap(){
        return Zap::all(); 
    }
    public function getEtab(){
        return Etablissement::all();
    }

    public function getclasse($niv){
        $res = [];
        switch ($niv) {
            case "EPP":
                $res = [
                    'Préscolaire','CP I - 11 ème','CP II - 10 ème',
                    'CM - 9 ème','CM I - 8 ème','CM II - 7 ème'
                ];
                break;
            case "CEG":
                $res = ['6 ème', '5 ème', '4 ème', '3 ème'];
                break;
            case "LYCEE":
                $res = ['Seconde', 'Première', 'Terminale'];
                break;
        }
        return $res;
    }

    public function createClasse(Request $request){
        $eror = request()->validate([
            'effectif' => 'required|integer|min:1'
        ]);
        
        return Classe::updateOrCreate(
            ['nom_cls' => $request->nom_classe,'id_etab' => $request->etab],
            ['eff_el' => $request->effectif]);
    }

    public function getEffectif(Request $request){
        $res = Classe::where('id_etab',$request->id_etab)->where('nom_cls',$request->nom_cls)->first();
        if($res){
            return $res->eff_el;
        }
        
    }
    
    public function createZap(Request $request){
        $eror = request()->validate([
            'lieu_zap' => 'required|unique:zaps'
        ]);
        return Zap::create([
            'lieu_zap' => $request->lieu_zap,
            'id_cisco' => $request->id_cisco
        ]);
    }

    public function etabList(){
        return DB::table('etablissements')->join('zaps','etablissements.id_zap','=','zaps.id_zap')
        ->join('ciscos','zaps.id_cisco','=','ciscos.id_cisco')->get();
    }

    public function updateEtab(Request $request){
        $eror = request()->validate([
            'code_etab' => 'required|min:3',
            'nom_etab' => 'required|unique:etablissements|min:3',
            'enseignant' => 'required|integer|min:1'
        ]);

        Etablissement::where('id_etab',$request->id_etab)->update([
            'code_etab' => $request->code_etab,
            'nom_etab' => $request->nom_etab,
            'eff_ens' => $request->enseignant,
            'id_zap' => $request->zap
        ]);

        $res = DB::table('etablissements')->where('etablissements.id_etab',$request->id_etab)
        ->join('zaps','etablissements.id_zap','=','zaps.id_zap')
        ->join('ciscos','zaps.id_cisco','=','ciscos.id_cisco')->get();

        return ['updated' => $res[0]];
    }

    public function delEtab($id){
        return Etablissement::destroy($id);
    }

    public function createEtab(Request $request){
        
        $validation = [];

        $validation['code_etab'] = 'required|unique:etablissements|min:3';
        $validation['nom_etab'] = 'required|unique:etablissements|min:3';
        $validation['enseignant'] = 'required|integer|min:1';

        switch ($request->niveau) {
            case "EPP":
                if($request->classe['prescolaire']){
                    $validation['classe.prescolaire'] = 'integer|min:1';
                }
                $validation['classe.cp1'] = 'required|integer|min:1';
                $validation['classe.cp2'] = 'required|integer|min:1';
                $validation['classe.cm'] = 'required|integer|min:1';
                $validation['classe.cm1'] = 'required|integer|min:1';
                $validation['classe.cm2'] = 'required|integer|min:1';
                break;
            case "CEG":
                $validation['classe.m6'] = 'required|integer|min:1';
                $validation['classe.m5'] = 'required|integer|min:1';
                $validation['classe.m4'] = 'required|integer|min:1';
                $validation['classe.m3'] = 'required|integer|min:1';
                break;
            case "LYCEE":
                $validation['classe.seconde'] = 'required|integer|min:1';
                $validation['classe.premiere'] = 'required|integer|min:1';
                $validation['classe.terminale'] = 'required|integer|min:1';
                break;
        }

        request()->validate($validation);

        $etab = Etablissement::create([
            'code_etab' => $request->code_etab,
            'nom_etab' => $request->nom_etab,
            'niveau' => $request->niveau,
            'eff_ens' => $request->enseignant,
            'id_zap' => $request->zap
        ]);
        $data = [];
        switch ($request->niveau) {
            case "EPP":
                $prescolaire = ($request->classe['prescolaire']) ? $request->classe['prescolaire'] : 0;
                $data[] = ['nom_cls' => 'Préscolaire' , 'eff_el' => $prescolaire, 'id_etab' => $etab->id_etab];
                $data[] = ['nom_cls' => '11 ème' , 'eff_el' => $request->classe['cp1'], 'id_etab' => $etab->id_etab];
                $data[] = ['nom_cls' => '10 ème' , 'eff_el' => $request->classe['cp2'], 'id_etab' => $etab->id_etab];
                $data[] = ['nom_cls' => '9 ème' , 'eff_el' => $request->classe['cm'], 'id_etab' => $etab->id_etab];
                $data[] = ['nom_cls' => '8 ème' , 'eff_el' => $request->classe['cm1'], 'id_etab' => $etab->id_etab];
                $data[] = ['nom_cls' => '7 ème' , 'eff_el' => $request->classe['cm2'], 'id_etab' => $etab->id_etab];
                break;
            case "CEG":
                $data[] = ['nom_cls' => '6 ème' , 'eff_el' => $request->classe['m6'], 'id_etab' => $etab->id_etab];
                $data[] = ['nom_cls' => '5 ème' , 'eff_el' => $request->classe['m5'], 'id_etab' => $etab->id_etab];
                $data[] = ['nom_cls' => '4 ème' , 'eff_el' => $request->classe['m4'], 'id_etab' => $etab->id_etab];
                $data[] = ['nom_cls' => '3 ème' , 'eff_el' => $request->classe['m3'], 'id_etab' => $etab->id_etab];
                break;
            case "LYCEE":
                $data[] = ['nom_cls' => 'Seconde' , 'eff_el' => $request->classe['seconde'], 'id_etab' => $etab->id_etab];
                $data[] = ['nom_cls' => 'Première' , 'eff_el' => $request->classe['premiere'], 'id_etab' => $etab->id_etab];
                $data[] = ['nom_cls' => 'Terminale' , 'eff_el' => $request->classe['terminale'], 'id_etab' => $etab->id_etab];
                break;
        }

        $res = DB::table('classes')->insert($data);

        return $res;

    }

    public function getEffectif_classe($idZap,$niveau){
        $res = Etablissement::where('id_zap',$idZap)->where('niveau',$niveau)
        ->select('id_etab','code_etab','nom_etab')->get();

        if($res){
            $total = 0;
            foreach($res as $r){
                $classes = Classe::where('id_etab',$r->id_etab)->get();
                if($classes){
                    switch ($niveau) {
                        case "EPP":
                            $r->prescolaire = $classes[0]->eff_el;
                            $r->cp1 = $classes[1]->eff_el;
                            $r->cp2 = $classes[2]->eff_el;
                            $r->cm = $classes[3]->eff_el;
                            $r->cm1 = $classes[4]->eff_el;
                            $r->cm2 = $classes[5]->eff_el;
                            $r->total = $r->cp1 +  $r->cp2 + $r->cm + $r->cm1 +$r->cm2;
                            break;
                        case "CEG":
        
                            $r->m6 = $classes[0]->eff_el;
                            $r->m5 = $classes[1]->eff_el;
                            $r->m4 = $classes[2]->eff_el;
                            $r->m3 = $classes[3]->eff_el;
                            $r->total = $r->m6 + $r->m5 + $r->m4 + $r->m3;
                            break;
                        case "LYCEE":
                            $r->seconde = $classes[0]->eff_el;
                            $r->premiere = $classes[1]->eff_el;
                            $r->terminale = $classes[2]->eff_el;
                            $r->total = $r->seconde + $r->premiere + $r->terminale;
                            break;
                    }
                }
            }
            
            return $res;
        }else{
            return [];
        }

 
    }

    public function updateEffectiff(Request $request){
        $validation = [];
        switch ($request->niveau) {
            case "EPP":
                if($request->classe['prescolaire']){
                    $validation['classe.prescolaire'] = 'integer|min:1';
                }
                $validation['classe.cp1'] = 'required|integer|min:1';
                $validation['classe.cp2'] = 'required|integer|min:1';
                $validation['classe.cm'] = 'required|integer|min:1';
                $validation['classe.cm1'] = 'required|integer|min:1';
                $validation['classe.cm2'] = 'required|integer|min:1';
                break;
            case "CEG":
                $validation['classe.m6'] = 'required|integer|min:1';
                $validation['classe.m5'] = 'required|integer|min:1';
                $validation['classe.m4'] = 'required|integer|min:1';
                $validation['classe.m3'] = 'required|integer|min:1';
                break;
            case "LYCEE":
                $validation['classe.seconde'] = 'required|integer|min:1';
                $validation['classe.premiere'] = 'required|integer|min:1';
                $validation['classe.terminale'] = 'required|integer|min:1';
                break;
        }
        request()->validate($validation);

        //$request->id_etab
        $classes = Classe::where('id_etab',$request->id_etab)->get();
        switch ($request->niveau) {
            case "EPP":
                $classes[0]->eff_el = $request->classe['prescolaire'];
                $classes[1]->eff_el = $request->classe['cp1'];
                $classes[2]->eff_el =$request->classe['cp2'];
                $classes[3]->eff_el = $request->classe['cm'];
                $classes[4]->eff_el = $request->classe['cm1'];
                $classes[5]->eff_el = $request->classe['cm2'];

                break;
            case "CEG":

                $classes[0]->eff_el = $request->classe['m6'];
                $classes[1]->eff_el = $request->classe['m5'];;
                $classes[2]->eff_el =$request->classe['m4'];
                $classes[3]->eff_el = $request->classe['m3'];
            
                break;
            case "LYCEE":
                $classes[0]->eff_el = $request->classe['seconde'];
                $classes[1]->eff_el = $request->classe['premiere'];
                $classes[2]->eff_el =$request->classe['terminale'];
             
                break;
        }

        foreach($classes as $cls){
            $cls->save();
        }

        return $classes;
        
    }

    public function updateEntre(Request $request){
        $eror = request()->validate([
            'qte_entre' => 'required|integer|min:1',
            'date_entre' => 'required|date'
        ]);
        
        Entre::where('id_e',$request->id_e)->update([
            'qte_entre' => $request->qte_entre,
            'date_entre' => Carbon::createFromFormat('d-m-Y',$request->date_entre)->format('Y-m-d')
        ]);
        
        $nouv = Entre::where('id_a',$request->id_a)->sum('qte_entre');

        return Stock::where('id_a',$request->id_a)->where('id_cisco',null)->update(['qte_st' => $nouv]);
    }

    public function updateRepart(Request $request){
        $eror = request()->validate([
            'qte_rep' => 'required|integer|min:1',
            'date_rep' => 'required|date'
        ]);
 
        Repartition::where('id_rep',$request->id_rep)->update([
            'qte_rep' => $request->qte_rep,
            'date_rep' => Carbon::createFromFormat('d-m-Y',$request->date_rep)->format('Y-m-d')
        ]);
        $cisco = Repartition::where('id_rep',$request->id_rep)->first();

        $nouv = Repartition::where('id_a',$request->id_a)->where('id_cisco',$cisco->id_cisco)->sum('qte_rep');

        return Stock::where('id_a',$request->id_a)->where('id_cisco',$cisco->id_cisco)->update(['qte_st' => $nouv]);
    }

    public function distribuer(DistRequest $request){
      
        foreach ($request->kits as $i => $kit){
            $dist = Distribution::create([
                'benef' => $request->benef, 'eff_benef' => $request->eff,
                'unite_dist' => $kit['unite_dist'], 'qte_dist' => $kit['qte_dist'],
                'date_dist' => Carbon::createFromFormat('d-m-Y',$request->date_dist)->format('Y-m-d'),
                'id_a' => $kit['id_a']
            ]);

            if($request->classe){
                Dist_class::create(['id_cls' => $request->classe, 'id_dist' => $dist->id_dist]);
            }else{
                Dist_etab::create(['id_etab' => $request->etab, 'id_dist' => $dist->id_dist]);
            }
            $nv_stock = $kit['qte_st'] - $kit['qte_dist'];
            $update = Stock::where('id_a',$kit['id_a'])->where('id_cisco',$request->cisco)->update(['qte_st' => $nv_stock]);
        }
        return true;
    }

    public function getRecap($id,$benef){
        //cisco eleves
        if($id >= 1){
            if($benef == "El"){
                return DB::table('zaps')->where('zaps.id_cisco',$id)
                ->join('ciscos','ciscos.id_cisco','=','zaps.id_cisco')
                ->join('etablissements','etablissements.id_zap','=','zaps.id_zap')
                ->join('classes','classes.id_etab','=','etablissements.id_etab')
                ->join('dist_class','dist_class.id_cls','=','classes.id_cls')
                ->join('distributions','distributions.id_dist','=','dist_class.id_dist')
                ->select('ciscos.lieu_cisco','zaps.id_zap','zaps.lieu_zap','etablissements.id_etab','etablissements.nom_etab',
                'distributions.benef',DB::raw('SUM(distributions.qte_dist) as qte'))
                ->groupBy('etablissements.id_etab')->get();
    
            }else{
                return DB::table('zaps')->where('zaps.id_cisco',$id)
                ->join('ciscos','ciscos.id_cisco','=','zaps.id_cisco')
                ->join('etablissements','etablissements.id_zap','=','zaps.id_zap')
                ->join('dist_etabs','dist_etabs.id_etab','=','etablissements.id_etab')
                ->join('distributions','distributions.id_dist','=','dist_etabs.id_dist')
                ->select('ciscos.lieu_cisco','zaps.id_zap','zaps.lieu_zap','etablissements.id_etab','etablissements.nom_etab',
                'distributions.benef',DB::raw('SUM(distributions.qte_dist) as qte'))
                ->where('distributions.benef',$benef)
                ->groupBy('etablissements.id_etab')->get();
            }
        }else{
            //eleves benef
            return DB::table('zaps')
                ->join('ciscos','ciscos.id_cisco','=','zaps.id_cisco')
                ->join('etablissements','etablissements.id_zap','=','zaps.id_zap')
                ->join('classes','classes.id_etab','=','etablissements.id_etab')
                ->join('dist_class','dist_class.id_cls','=','classes.id_cls')
                ->join('distributions','distributions.id_dist','=','dist_class.id_dist')
                ->select('ciscos.lieu_cisco','zaps.id_zap','zaps.lieu_zap','etablissements.id_etab','etablissements.nom_etab',
                'distributions.benef',DB::raw('SUM(distributions.qte_dist) as qte'))
                ->groupBy('etablissements.id_etab')->get();
        }
    }

    public function getbilan(){
        $ciscos = Cisco::all();
        $labels = [];
        $datasets = [];
        foreach($ciscos as $cisco){
            $labels[] = ['Cisco',$cisco->lieu_cisco];

            $res = DB::table('zaps')
            ->join('ciscos','ciscos.id_cisco','=','zaps.id_cisco')
            ->join('etablissements','etablissements.id_zap','=','zaps.id_zap')
            ->join('classes','classes.id_etab','=','etablissements.id_etab')
            ->join('dist_class','dist_class.id_cls','=','classes.id_cls')
            ->join('distributions','distributions.id_dist','=','dist_class.id_dist')
            ->select('ciscos.lieu_cisco',DB::raw('SUM(distributions.qte_dist) as qte'))
            ->where('ciscos.lieu_cisco',$cisco->lieu_cisco)
            ->groupBy('ciscos.id_cisco')->get();

            $datasets[] = (count($res) > 0) ? intval($res[0]->qte) : 0;
        }
        return [
            'labels' => $labels,
            'datasets' => $datasets
        ];
    }

    
    public function getHistoDist($benef, $id){

        if($benef == 'El'){
            $res = DB::table('etablissements')
            ->join('classes','classes.id_etab','=','etablissements.id_etab')
            ->join('dist_class','dist_class.id_cls','=','classes.id_cls')
            ->join('distributions','distributions.id_dist','=','dist_class.id_dist')
            ->join('articles','articles.id_a','=','distributions.id_a')
            ->select('distributions.id_dist','articles.design',
            'etablissements.nom_etab','classes.nom_cls',
            'distributions.unite_dist','distributions.eff_benef','distributions.qte_dist',
            'distributions.date_dist')->where('etablissements.id_etab',$id)->get();
        }else{
            $res = DB::table('etablissements')
            ->join('dist_etabs','dist_etabs.id_etab','=','etablissements.id_etab')
            ->join('distributions','distributions.id_dist','=','dist_etabs.id_dist')
            ->join('articles','articles.id_a','=','distributions.id_a')
            ->select('distributions.id_dist','articles.design',
            'etablissements.nom_etab','distributions.unite_dist','distributions.eff_benef',
            'distributions.qte_dist','distributions.date_dist')
            ->where('etablissements.id_etab',$id)
            ->where('distributions.benef',$benef)->get();
        }
        
        foreach($res as $el){
            $el->date_dist = Carbon::createFromFormat('Y-m-d',$el->date_dist)->format('d-m-Y');
        }
        return $res;
    } 

    private function mute($param){
        if($param == 'El'){
            return 'Elève';
        }else if($param == 'En'){
            return 'Enseignant';
        }else{
            return 'Etablissement';
        }
    }

    public function getDetail($id,$benef){
        if($benef == "El"){
            $res = DB::table('etablissements')->where('etablissements.id_etab',$id)
            ->join('classes','classes.id_etab','=','etablissements.id_etab')
            ->join('dist_class','dist_class.id_cls','=','classes.id_cls')
            ->join('distributions','distributions.id_dist','=','dist_class.id_dist')
            ->join('articles','articles.id_a','=','distributions.id_a')
            ->join('sources','sources.id_s','=','articles.id_s')
            ->select('articles.id_a','articles.design','sources.source','distributions.benef',
            DB::raw('SUM(distributions.qte_dist) as qte'))
            ->groupBy('distributions.id_a')->get();

        }else{
            
            $res = DB::table('etablissements')->where('etablissements.id_etab',$id)
            ->join('dist_etabs','dist_etabs.id_etab','=','etablissements.id_etab')
            ->join('distributions','distributions.id_dist','=','dist_etabs.id_dist')
            ->join('articles','articles.id_a','=','distributions.id_a')
            ->join('sources','sources.id_s','=','articles.id_s')
            ->select('articles.id_a','articles.design','sources.source','distributions.benef',
            DB::raw('SUM(distributions.qte_dist) as qte'))
            ->where('distributions.benef',$benef)
            ->groupBy('distributions.id_a')->get();
        }

        foreach($res as $r){
            $r->benef = $this->mute($r->benef);
        }
        return $res;
    }

    public function recapStock(){

        $res =  DB::table('stocks')->join('articles','articles.id_a','=','stocks.id_a')
        ->join('sources','sources.id_s','=','articles.id_s')
        ->select('articles.id_a','articles.design','sources.source',
        DB::raw('SUM(stocks.qte_st) as qte_stock'))->groupBy('stocks.id_a')->get();

        foreach($res as $r){
            $dist = DB::table('distributions')->where('id_a',$r->id_a)
            ->select('id_a',DB::raw('SUM(qte_dist) as qte_distribue'))->groupBy('id_a')->get(1);
            $r->qte_distribue = (count($dist) > 0) ? $dist[0]->qte_distribue : 0;
            $r->qte_recue = $r->qte_stock + $r->qte_distribue;
        }
        return $res;
    }

    public function getbilanStock(){
        $res =  DB::table('stocks')->join('articles','articles.id_a','=','stocks.id_a')
        ->join('sources','sources.id_s','=','articles.id_s')
        ->select('articles.design as label',
        DB::raw('SUM(stocks.qte_st) as value'))->groupBy('stocks.id_a')->get();

        foreach($res as $r){
            $label[] = ['label' => $r->label];
            $value[] = ['value' => $r->value];
        }
        $dataset[] = [
            'seriesname' => 'Totaux',
            'initiallyhidden' => '1',// hide seriename
            'data' => $value
        ];
        $ciscos = Cisco::all();
        $articles = Article::all();

        foreach($ciscos as $cisco){
            $val = [];
            foreach($articles as $art){
                $res = Stock::where('id_cisco',null)->where('id_a',$art->id_a)->get();
                $stock = (count($res) > 0) ? $res[0]->qte_st : "0";
                $val[] = ['value' => $stock];
            }
        }
        $dataset[] = [
            'seriesname' => 'Dren',
            'initiallyhidden' => '1',// hide seriename
            'data' => $val
        ];
        foreach($ciscos as $cisco){
            $value = [];
            foreach($articles as $art){
                $res = Stock::where('id_cisco',$cisco->id_cisco)->where('id_a',$art->id_a)->get();
                $stock = (count($res) > 0) ? $res[0]->qte_st : "0";
                $value[] = ['value' => $stock];
            }
            $dataset[] = [
                'seriesname' => $cisco->lieu_cisco,
                'data' => $value
            ];
        }

        return [
            'label' => $label,
            'dataset' => $dataset
        ];
    }
   
}
