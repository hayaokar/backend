<?php

use App\Http\Controllers\AdminCountry;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/hello',function(){
    $array=array(array("name"=>"dsdc","photo"=>"fwe"),array("name"=>"fewfe","photo"=>"ferfe"));
    echo json_encode($array);
});
Route::resource('adminCountries',AdminCountry::class);
Route::get('createTrain',function(){

    \App\Models\training_opp::create(['company_id'=>1,'name'=>'dvs','number of seats'=>3
    ,'duration'=>3,'target'=>'sca','name'=>'sdasd']);


});
Route::get('add_train',function(){
    $s=\App\Models\student::findorfail(1);
    $t=\App\Models\training_opp::findorfail(1);
    $s->training_opps()->save($t);
});

Route::get('add_e',function(){
    $u=\App\Models\university::findorfail(1);
    $e=\App\Models\exchange_program::findorfail(1);
    $u->exchange_programs()->save($e);
});
