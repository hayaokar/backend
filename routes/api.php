<?php

use App\Http\Controllers\AdminCountry;
use App\Http\Controllers\AdminExchangeProgram;
use App\Http\Controllers\AdminScholarship;
use App\Http\Controllers\AdminStudent;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TrainingOpp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Scholarship;
use App\Models\Company;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/hello',function(){
    return "hello";
});
Route::get('/getScholarShipsCountries',function(){

     $scholarships=Scholarship::all();
     $countries=[];
     foreach ($scholarships as $scholarship){
         $countries[]=$scholarship->country;
     }
     return $countries;
});
Route::get('/avtivateCompany/{id}',function($id){
    $c=Company::findorfail($id);
    $c->update(['activated'=>'1']);


});
Route::resource('adminScholarship',AdminScholarship::class);
Route::resource('adminUser',AdminStudent::class);
Route::resource('company',CompanyController::class);
Route::resource('adminCountries',AdminCountry::class);
Route::resource('adminExchangeProgram',AdminExchangeProgram::class);
Route::resource('trainingOpp',TrainingOpp::class);

Route::post('register','App\Http\Controllers\loginController@register');
