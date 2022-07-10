<?php

use App\Http\Controllers\AdminCountry;
use App\Http\Controllers\AdminExchangeProgram;
use App\Http\Controllers\AdminScholarship;
use App\Http\Controllers\AdminStudent;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TrainingOpp;
use App\Models\student;
use App\Models\training_opp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    $data=array();
    $Id=array();
     foreach ($scholarships as $scholarship){
         if(!(in_array($scholarship->country->id,$Id))){
             $d=array("id"=>$scholarship->country->id,"name"=>$scholarship->country->name,"photo"=>$scholarship->country->photo ? "http://localhost//backEnd//public//".$scholarship->country->photo->file : 'no photo');
             array_push($data,$d);
             array_push($Id,$scholarship->country->id);
         }
     }
     return $data;


});
Route::get('getScholarships/{id}',function($id){
    $scholarships = Scholarship::where('country_id',$id)->get();
    $data=array();
    foreach ($scholarships as $scholarship){
        $d=array("id"=>$scholarship->id,"name"=>$scholarship->name,"photo"=>$scholarship->photo ? "http://localhost//backEnd//public//".$scholarship->photo->file : 'no photo');
        array_push($data,$d);
    }
    return json_encode($data);
});

Route::get('trainingOpp',[TrainingOpp::class,'index']);

Route::get('scholarship/{id}',[AdminScholarship::class,'show']);

Route::post('register','App\Http\Controllers\loginController@register');

Route::post('login','App\Http\Controllers\loginController@login');

Route::get('trainingOpp/{id}',[TrainingOpp::class,'show']);

Route::get('exchangePrograms',[AdminExchangeProgram::class,'index']);

Route::get('exchangePrograms/{id}',[AdminExchangeProgram::class,'show']);

Route::get('adminCountries',[AdminCountry::class,'index']);

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
//        Route::resource('adminCountries',AdminCountry::class);
        Route::post('adminCountries',[AdminCountry::class,'store']);
        Route::put('adminCountries/{id}',[AdminCountry::class,'update']);
        Route::delete('adminCountries/{id}',[AdminCountry::class,'destroy']);
        Route::delete('deleteCompany/{id}',[CompanyController::class,'destroy']);//to admin delete company
        Route::get('usersNumber',function(){
            $u=\App\Models\User::all();
            return $u->count();
        });
        Route::get('countriesNumber',function(){
            $c=\App\Models\Country::all();
            return $c->count();
        });
        Route::get('scholarshipsNumber',function(){
            $s=Scholarship::all();
            return $s->count();
        });
        Route::get('trainingNumber',function(){
            $t=training_opp::all();
            return $t->count();
        });




    });
    Route::group(['middleware'=>'company'],function(){
        Route::put('updateCompanyInfo',[CompanyController::class,'update']);//to company to update information
        Route::post('trainingOpp',[TrainingOpp::class,'store']);
        Route::put('trainingOpp/{id}',[TrainingOpp::class,'update']);
        Route::delete('trainingOpp/{id}',[TrainingOpp::class,'destroy']);
        Route::get('myTraining',[TrainingOpp::class,'companyTraining']);
        Route::post('acceptStudent/{t_id}/{s_id}',[CompanyController::class,'acceptStudent']);
        Route::post('rejectStudent/{t_id}/{s_id}',[CompanyController::class,'rejectStudent']);
        Route::get('companyTrainingNumber',[CompanyController::class,'companyTrainingNumber']);
        Route::get('trainingStudents/{id}',[TrainingOpp::class,'trainingStudents']);
        Route::get('numberOfStudents',[CompanyController::class,'numberOfStudents']);
        Route::get('company/{id}',[CompanyController::class,'show']);

    });

    Route::post('Apply/{id}',function ($id,Request $request){
        $t=training_opp::findorfail($id);
        $id=Auth::user()->id;
        $s=student::findorfail($id);
        if($file=$request->file('certificates')) {

            $name = time() . $file->getClientOriginalName();

            $file->move('studentsCertificates', $name);

            $s->update(['certificates' => $name]);

        }

        $t->students()->save($s);


    })->middleware('student');




}
);

