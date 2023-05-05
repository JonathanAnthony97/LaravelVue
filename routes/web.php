<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::redirect('/', '/login');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//article
Route::get('/article', 'ArticleController@index');
Route::get('/getArticle','ArticleController@getArticle');
Route::get('/getArticle_Dren/{id?}','ArticleController@getArticle_Dren');

Route::put('/update_art','DistController@updateArt');
Route::put('/update_entre','DistController@updateEntre');
Route::put('/update_repart','DistController@updateRepart');
Route::get('/getzap','DistController@getzap');

Route::get('/etab_list','DistController@etabList');
Route::post('/create_etab','DistController@createEtab');

Route::get('/getlistCisco','ArticleController@getCiscos');
Route::get('/getCisco/{id}','ArticleController@getOrder');

Route::post('/article','ArticleController@store');
Route::post('/article_def','ArticleController@defect');
Route::delete('/article/{id}','ArticleController@destroy');
Route::post('/allDelete','ArticleController@allDelete');
Route::post('/getData','ArticleController@getData');

Route::post('/getSelected','ArticleController@getSelected');

Route::post('/repartir','ArticleController@repartir');
Route::post('/repartir_pdf','ArticleController@repartirPdf');

Route::get('/histo_entre','ArticleController@getHisto');
Route::get('/histo_repart/{id?}','ArticleController@getHistoRepart');
Route::get('/stock_repart/{id}','ArticleController@stock_repart');

Route::delete('/del_entre/{id}','ArticleController@delEntre');
Route::post('/del_entres','ArticleController@delEntres');

Route::delete('/del_repart/{id}','ArticleController@delRepart');
Route::post('/del_reparts','ArticleController@delReparts');

Route::get('/getzap/{id}','ArticleController@getzap');
Route::get('/getEtab','DistController@getEtab');

Route::get('/get_nomClasse/{niv}','DistController@getclasse');

Route::get('/getetab/{id}','ArticleController@getetab');
Route::get('/getEtab','ArticleController@get_Etab');

Route::get('/getclasse/{id}','ArticleController@getclasse');
Route::post('/create_classe','DistController@createClasse');
Route::post('/create_zap','DistController@createZap');
Route::post('/getEffectif','DistController@getEffectif');

Route::post('/distribuer','DistController@distribuer');

Route::post('/update_etab','DistController@updateEtab');

Route::delete('/del_etab/{id}','DistController@delEtab');

Route::get('/effectifs_classe/{idZap}/{niveau}','DistController@getEffectif_classe');

Route::post('/update_classe','DistController@updateEffectiff');

Route::get('/recap_dist/{id}/{benef}','DistController@getRecap');
Route::get('/getbilan','DistController@getBilan');
Route::get('/getbilanStock','DistController@getbilanStock');


Route::get('/detail_dist/{id}/{benef}','DistController@getDetail');

Route::get('/histo_dist/{benef}/{id_a}','DistController@getHistoDist');

Route::delete('/del_dist/{id}','ArticleController@deleteDist');

Route::get('/recap_stock','DistController@recapStock');
Route::post('/add_cisco','ArticleController@addCisco');

//PDF
Route::post('/recapDistPdf','ArticleController@recapDistPdf');

Route::get('/recapStockPdf','ArticleController@recapStockPdf');
//
//Route::resource('article', 'ExeController');
 
