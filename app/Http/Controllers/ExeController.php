<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use Carbon\Carbon;
use App\Http\Requests\StoreArticle;

class ExeController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::all();

        foreach ($articles as $a) {
            $a->entrer = Carbon::createFromFormat('Y-m-d',$a->entrer)->format('d-m-Y');
        }
        return response()->json($articles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $comment = Article::find(2);

        echo $comment->source->src;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'design' => 'unique:articles|min:3',
            'qte' => 'integer|min:0',
            'entrer' => 'date'
        ]);

        return Article::create([
            'design' => $data['design'],//$request->design,
            'qte' => $data['qte'],// $request->qte,
            'entrer' => Carbon::createFromFormat('d-m-Y',$request->entrer)->format('Y-m-d'),
            'id_s' => 1
        ]);
        //return response()->json($ar);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Article::destroy($id);
    }

    public function allDelete(Request $list){

       $res = Article::destroy($list->data);
       return $res;
    }
}
