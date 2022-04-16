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

Route::get('/getScholarshipsCountries',function(){

     $scholarships=Scholarship::all();
     $countries=[];
     foreach ($scholarships as $scholarship){
         $countries[]=$scholarship->country;
     }
     return $countries;
});
Route::get('getScholarships/{id}',function($id){
    return Scholarship::where('country_id',$id)->get();
});

Route::post('register','App\Http\Controllers\loginController@register');

Route::post('login','App\Http\Controllers\loginController@login');


Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::post('logout','App\Http\Controllers\loginController@logout');
    Route::group(['middleware'=>'admin'],function(){
        Route::get('showAllCompanies',[CompanyController::class,'index']);//to admin to show all companies
        Route::post('ActivateCompany/{id}',function ($id){
            $company=Company::findorfail($id);
            $company->update(['activated'=>'1']);
            return $company;


        });
        Route::resource('adminScholarship',AdminScholarship::class);
        Route::resource('adminUser',AdminStudent::class); //maybe delete not added to the table
        Route::resource('adminExchangeProgram',AdminExchangeProgram::class);
        Route::resource('adminCountries',AdminCountry::class);
        Route::delete('deleteCompany/{id}',[CompanyController::class,'destroy']);//to admin delete company
        Route::get('trainingOpp',[TrainingOpp::class,'index']);


    });
    Route::group(['middleware'=>'company'],function(){
        Route::put('updateCompanyInfo',[CompanyController::class,'update']);//to company to update information
        Route::post('trainingOpp',[TrainingOpp::class,'store']);
        Route::put('trainingOpp/{id}',[TrainingOpp::class,'update']);
        Route::delete('trainingOpp/{id}',[TrainingOpp::class,'destroy']);
        Route::get('myTraining',[TrainingOpp::class,'companyTraining']);

    });













}
);

