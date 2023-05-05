<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RepartRequest;
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
use Carbon\Carbon;
use App\User;
use PDF;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return DB::table('articles')->join('sources','articles.id_s','=','sources.id_s')
        ->join('stocks','stocks.id_a','=','articles.id_a')->where('stocks.id_cisco','=',null)
        ->select('articles.*','sources.source','stocks.qte_st')
        ->get();
        //return response()->json($art);

        /*foreach ($art as $a) {
            $a->entrer = Carbon::createFromFormat('Y-m-d',$a->entrer)->format('d-m-Y');
        }*/
    }

    public function getArticle(){
        return Article::get(['id_a','design']);
    }
    public function getArticle_Dren($id = null){
        return DB::table('articles')
        ->join('stocks','stocks.id_a','=','articles.id_a')->where('stocks.id_cisco','=',$id)
        ->select('articles.*')->get();
    }
    
    public function getCiscos(){
        $cisco = Cisco::all();
        $source = Source::all();

        return [
            'ciscos' => $cisco,
            'sources' => $source
        ];
    }

    public function getOrder($id){
        $first = Cisco::find($id);
        $cisco = Cisco::where('id_cisco','!=',$id)->get();
        $res = []; $res[0] = $first;
        foreach ($cisco as $c => $val) { 
            $res[$c + 1] = $val;
        }
        return $res;
    }


    public function store(Request $request)
    {
        $validations = [
            'qte_entre' => 'required|integer|min:0',
            'date_entre' => 'required|date'
        ];
        if($request->design){
            $validations['src'] = 'required';
            $validations['design'] = 'required|unique:articles|min:3';
            
        }else if(!$request->design && !$request->id){
            $validations['id'] = 'required';
            $validations['design'] = 'required|unique:articles|min:3';
        }

        $data = request()->validate($validations);

        if($request->id){
            if($request->depot){
                $stock = Stock::where('id_a',$request->id)->where('id_cisco',$request->depot)->first();
                if($stock){
                    $qte_actuel = $stock->qte_st + $request->qte_entre;
                    $res = Stock::where('id_st',$stock->id_st)->update(['qte_st' => $qte_actuel]);

                }else{
                    $nouv = Stock::create([
                        'qte_st' => $request->qte_entre,
                        'id_a' => $request->id,
                        'id_cisco' => $request->depot
                    ]);
                    $res = $nouv->id_st;
                }
                
                Repartition::create([
                    'date_rep' => Carbon::createFromFormat('d-m-Y',$request->date_entre)->format('Y-m-d'),
                    'qte_rep' => $request->qte_entre, 
                    'id_a' => $request->id,
                    'id_cisco' => $request->depot
                ]);
            }else{
                
                $stock = Stock::where('id_a',$request->id)->where('id_cisco',null)->first();
                if($stock){
                    $qte_actuel = $stock->qte_st + $request->qte_entre;
                    $res = Stock::where('id_st',$stock->id_st)->update(['qte_st' => $qte_actuel]);
                }else{
                    $nouv = Stock::create([
                        'qte_st' => $request->qte_entre,
                        'id_a' => $request->id
                    ]);
                    $res = $nouv->id_st;
                }
                //insertion 
                Entre::create([
                    'qte_entre' => $request->qte_entre, 
                    'date_entre' => Carbon::createFromFormat('d-m-Y',$request->date_entre)->format('Y-m-d'),
                    'id_a' => $request->id
                ]);
            }
            $res = Article::where('id_a',$request->id)->first();
        }else{
            $article = Article::create([
                'design' => $request->design,
                'id_s' => $request->src
            ]);
            //historisation
            if($request->depot){
                $nouv = Stock::create([
                    'qte_st' => $request->qte_entre,
                    'id_a' => $article->id_a,
                    'id_cisco' => $request->depot
                ]);
                Repartition::create([
                    'date_rep' => Carbon::createFromFormat('d-m-Y',$request->date_entre)->format('Y-m-d'),
                    'qte_rep' => $request->qte_entre, 
                    'id_a' => $article->id_a,
                    'id_cisco' => $request->depot
                ]);

            }else{
                $nouv = Stock::create([
                    'qte_st' => $request->qte_entre,
                    'id_a' => $article->id_a,
                ]);
                Entre::create([
                    'qte_entre' => $request->qte_entre, 
                    'date_entre' => Carbon::createFromFormat('d-m-Y',$request->date_entre)->format('Y-m-d'),
                    'id_a' => $article->id_a
                ]);
            }
            $res = $article;
        }
        return $res;
    }

    public function defect(Request $request){
        $max = 0;
        $new = 0;
        $valid = '';
        if($request->id){
            $stock = Stock::where('id_a',$request->id);
            if($request->depot){
                $max = $stock->where('id_cisco',$request->depot)->first();
                $valid = '|max:'.$max->qte_st;
            }else{
                $max = $stock->first();
                $valid = '|max:'.$max->qte_st;
            }
        }
        $data = request()->validate([
            'id' => 'required',
            'qte_entre' => 'required|integer|min:1'.$valid,
        ]);
       
        $res = Defectueu::create([
            'qte_def' => $request->qte_entre,
            'id_a' => $request->id
        ]);
        if($res){
            $new = $max->qte_st - $request->qte_entre;
            Stock::where('id_st',$max->id_st)->update(['qte_st' => $new]);
        }
        return $res->id;
    }

    public function destroy($id){
        return Article::destroy($id);
    }

    public function allDelete(Request $list){
        $res = Article::destroy($list->data);
        return $res;
     }

    public function getData (Request $list){
        //$tab = [2,15,17,21];
       $res =  DB::table('articles')->join('sources','articles.id_s','=','sources.id_s')
        ->join('stocks','stocks.id_a','=','articles.id_a')
        ->where('stocks.id_cisco','=',null)->whereIn('articles.id_a', $list->data)
        ->select('articles.*','sources.source','stocks.qte_st')->get();
        foreach ($res as $r) { $r->sortie = '';}
        return $res;

    }
    public function repartir(RepartRequest $request){
        //insertionn dans repartitions
        $data = [];
        foreach ($request->article as $i => $art){
            $stk = Stock::where('id_a',$art['id_a'])->where('id_cisco',null)->first();
            $stk->qte_st = $stk->qte_st - $art['sortie'];
            $stk->save();
            $s = Stock::where('id_a',$art['id_a'])->where('id_cisco',$request->cisco)->first();
            if($s){
                $s->qte_st = $s->qte_st + $art['sortie'];
                $s->save();
            }else{
                Stock::create([
                    'qte_st' =>$art['sortie'],
                    'id_a' => $art['id_a'],
                    'id_cisco' =>  $request->cisco
                ]);
            }

            $data[$i] = ['date_rep' => Carbon::createFromFormat('d-m-Y',$request->date)->format('Y-m-d'),
                'qte_rep' => $art['sortie'],
                'id_a' => $art['id_a'],
                'id_cisco' => $request->cisco];
        }
        $res = DB::table('repartirs')->insert($data);
        return $res;
    }



    public function getHisto(){
        $articles =  DB::table('entres')->join('articles','articles.id_a','=','entres.id_a')
        ->join('sources','sources.id_s','=','articles.id_s')
        ->select('entres.*','sources.source','articles.design')
        ->get();

        foreach ($articles as $a) {
            $a->date_entre = Carbon::createFromFormat('Y-m-d',$a->date_entre)->format('d-m-Y');
        }
        return $articles;
    }
    public function getHistoRepart($id = null){
        if($id){
            $histo = DB::table('repartirs')->join('articles','articles.id_a','=','repartirs.id_a')
            ->join('sources','sources.id_s','=','articles.id_s')->where('repartirs.id_cisco',$id);
        }else{
            $histo = DB::table('repartirs')->join('articles','articles.id_a','=','repartirs.id_a')
            ->join('sources','sources.id_s','=','articles.id_s');
        }
        $histo = $histo->select('repartirs.*','sources.source','articles.design')->get();

        foreach ($histo as $h) { 
            $h->date_rep = Carbon::createFromFormat('Y-m-d',$h->date_rep)->format('d-m-Y');
        }
        return $histo;
    }

    public function stock_repart($id){
        return DB::table('articles')->join('sources','sources.id_s','=','articles.id_s')
        ->join('stocks','stocks.id_a','=','articles.id_a')->where('stocks.id_cisco','=',$id)
        ->select('articles.*','sources.source','stocks.id_st','stocks.qte_st')->get();

    }

    public function getSelected(Request $request){
        $res =  DB::table('articles')->join('sources','sources.id_s','=','articles.id_s')
        ->join('stocks','stocks.id_a','=','articles.id_a')->where('stocks.id_cisco','=',$request->id)
        ->whereIn('stocks.id_a', $request->data)->select('articles.*','sources.source','stocks.qte_st')->get();
        
        foreach ($res as $r) { $r->unite_dist = ''; $r->qte_dist = 0 ;}

        return $res;
        
    }

    public function addCisco(Request $request){
        request()->validate([
            'lieu_cisco' => 'required|unique:ciscos|min:3'
        ]);
        
        return Cisco::create([
            'lieu_cisco' => $request->lieu_cisco
        ]);
    }

    public function getzap($id){
        return Zap::where('id_cisco',$id)->get();
    }
    
    public function getetab($id){
        return Etablissement::where('id_zap',$id)->get();
    }

    public function get_Etab(){
        return Etablissement::all();
    }

    public function getclasse($id){
        return Classe::where('id_etab',$id)->get();
    }

    public function delEntre($id){
        return Entre::destroy($id);
    }

    public function delEntres(Request $request){
        return Entre::destroy($request->data);
    }

    public function delRepart($id){
        return Repartition::destroy($id);
    }
    public function deleteDist($id){
        return Distribution::destroy($id);
    }

    public function delReparts(Request $request){
        return Repartition::destroy($request->data);
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

    public function recapDistPdf(Request $request){
        $logo = base64_encode(file_get_contents(public_path('/logo/logo.jpg')));
        $logo2 = base64_encode(file_get_contents(public_path('/logo/logo2.jpg')));
        
        $cisco = strtoupper($request->lieu_cisco);
        $zap = strtoupper($request->lieu_zap);
        $etab = Etablissement::where('id_etab',$request->id_etab)->first();
        $niveau = $etab->niveau;
        $ecole = strtoupper($etab->nom_etab);
        $code = strtoupper($etab->code_etab);
        
        if($request->benef == "El"){
            $res = DB::table('etablissements')->where('etablissements.id_etab',$request->id_etab)
            ->join('classes','classes.id_etab','=','etablissements.id_etab')
            ->join('dist_class','dist_class.id_cls','=','classes.id_cls')
            ->join('distributions','distributions.id_dist','=','dist_class.id_dist')
            ->join('articles','articles.id_a','=','distributions.id_a')
            ->join('sources','sources.id_s','=','articles.id_s')
            ->select('articles.id_a','articles.design','sources.source','distributions.benef',
            DB::raw('SUM(distributions.qte_dist) as qte'))
            ->groupBy('distributions.id_a')->get();

        }else{
            
            $res = DB::table('etablissements')->where('etablissements.id_etab',$request->id_etab)
            ->join('dist_etabs','dist_etabs.id_etab','=','etablissements.id_etab')
            ->join('distributions','distributions.id_dist','=','dist_etabs.id_dist')
            ->join('articles','articles.id_a','=','distributions.id_a')
            ->join('sources','sources.id_s','=','articles.id_s')
            ->select('articles.id_a','articles.design','sources.source','distributions.benef',
            DB::raw('SUM(distributions.qte_dist) as qte'))
            ->where('distributions.benef',$request->benef)
            ->groupBy('distributions.id_a')->get();
        }

        foreach($res as $r){
            $r->benef = $this->mute($r->benef);
        }

        $counter = count($res);
        $total = $request->qte;
        $current_year = date("Y");
        $prev_year = $current_year - 1;
        $anne_scolaire = $prev_year.'-'.$current_year ;
        //return $res;

        $pdf = PDF::loadView('recapDistPdf',compact(
            'res','logo','logo2','cisco','zap','niveau','ecole','code','counter','total','anne_scolaire'
        ))->setPaper('a4','landscape');

        $fic = 'recap_distribution_etablissement_'.$ecole.'_'.$anne_scolaire.'.pdf';
        return $pdf->download($fic);
        //return view('test',compact('users','logo','logo2'));
        /*return view('recapDistPdf',compact(
            'res','logo','logo2','cisco','zap','niveau','ecole','code','counter','total','anne_scolaire'));*/
    }




    public function recapStockPdf(){
        $logo = base64_encode(file_get_contents(public_path('/logo/logo.jpg')));
        $logo2 = base64_encode(file_get_contents(public_path('/logo/logo2.jpg')));

        $res =  DB::table('stocks')->join('articles','articles.id_a','=','stocks.id_a')
        ->join('sources','sources.id_s','=','articles.id_s')
        ->select('articles.id_a','articles.design','sources.source',
        DB::raw('SUM(stocks.qte_st) as qte_stock'))->groupBy('stocks.id_a')->get();

        $total_recue = 0;
        $total_distribue = 0;
        $total_stock = 0;
        $counter = count($res);

        $current_year = date("Y");
        $prev_year = $current_year - 1;
        $anne_scolaire = $prev_year.'-'.$current_year ;

        foreach($res as $r){
            $dist = DB::table('distributions')->where('id_a',$r->id_a)
            ->select('id_a',DB::raw('SUM(qte_dist) as qte_distribue'))->groupBy('id_a')->get(1);
            $r->qte_distribue = (count($dist) > 0) ? $dist[0]->qte_distribue : 0;
            $r->qte_recue = $r->qte_stock + $r->qte_distribue;

            $total_recue += $r->qte_recue;
            $total_distribue += $r->qte_distribue;
            $total_stock += $r->qte_stock;
        }
        
        $pdf = PDF::loadView('recapStockPdf',compact(
            'res','logo','logo2','counter','anne_scolaire','total_recue','total_distribue','total_stock'
        ))->setPaper('a4','landscape');
        
        $fic = "recap_stock_".$anne_scolaire.'.pdf';

        return $pdf->download($fic);

        /*return view('recapStockPdf',compact(
            'res','logo','logo2','counter','anne_scolaire','total_recue','total_distribue','total_stock'));*/
    }

    public function repartirPdf(RepartRequest $request){
        $logo = base64_encode(file_get_contents(public_path('/logo/logo.jpg')));
        $logo2 = base64_encode(file_get_contents(public_path('/logo/logo2.jpg')));

        $cisco = Cisco::where('id_cisco',$request->cisco)->first()->lieu_cisco;
        $res = $request->article;
        $counter = count($res);
        $total = 0;
        foreach ($request->article as $i => $art){
            $total += $art['sortie'];
        }
      
        Carbon::setlocale('fr');
        $current_date = Carbon::createFromFormat('d-m-Y',$request->date)->translatedFormat('d F Y');
        $current_year = date("Y");
        $prev_year = $current_year - 1;
        $anne_scolaire = $prev_year.'-'.$current_year;
        
        $pdf = PDF::loadView('repartitionPdf',compact(
            'cisco','res','logo','logo2','counter','anne_scolaire','total','current_date'
        ))->setPaper('a4','landscape');
        
        $fic = 'sortie_article_cisco_'.$cisco.'_'.$request->date.'.pdf';
        return $pdf->download($fic);

        /*return view('repartitionPdf',compact('cisco','res','logo','logo2','counter','anne_scolaire','total',
        'current_date'));*/
        
    }
    

    
}
