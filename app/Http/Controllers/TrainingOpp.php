<?php

namespace App\Http\Controllers;

use App\Models\training_opp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingOpp extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Training_opp::all();
    }

    public function companyTraining(){
        $id=Auth::user()->id;


        return Training_opp::where('company_id',$id)->get();

    }

    public function companyTrainingNumber(){
        $id=Auth::user()->id;


        $t = Training_opp::where('company_id',$id)->get();

        return $t->count();

    }

    public function trainingStudents($id){

        $t=training_opp::findorfail($id);
        if(Auth::user()->id == $t->company_id){
            return $t->students()->get();
        }
        return response()->json([
            'message'=>'not your training opportunity'
        ],423);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id=Auth::user()->id;
        $request['company_id']=$id;
        return Training_opp::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Training_opp::findorfail($id);
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
        $company_id=Training_opp::findorfail($id)->company_id;
        $auth_id=Auth::user()->id;
        if($company_id==$auth_id){
            $t=Training_opp::findorfail($id);
            $t->update($request->all());
            return $t;
        }

        return "this is not your training ";

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $t=Training_opp::findorfail($id);
        $t->students()->detach();
        $t->delete();
    }
}
