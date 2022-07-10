<?php

namespace App\Http\Controllers;

use App\Models\student;
use App\Models\training_opp;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Company::all();
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
        Company::create($request->all);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->id==$id){
            return Company::findorfail($id);
        }

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
    public function update(Request $request)
    {
        $id= Auth::user()->id;
        $c=Company::findorfail($id);
        $u=User::findorfail($id);
        $c->update($request->all());
        $u->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $c=Company::findorfail($id);
        $c->delete();
        training_opp::where('company_id',$id)->delete();
    }

    public function acceptStudent($t_id,$s_id){
        $t=training_opp::findorfail($t_id);
        if(Auth::user()->id==$t->company_id){
            $student=student::findorfail($s_id);
            $t->students()->updateExistingPivot($student, array('student_status' => 'accepted'), false);
        }
    }
    public function rejectStudent($t_id,$s_id){
        $t=training_opp::findorfail($t_id);
        if(Auth::user()->id==$t->company_id){
            $student=student::findorfail($s_id);
            $t->students()->updateExistingPivot($student, array('student_status' => 'rejected'), false);
        }
    }


    public function numberOfStudents(){
        $id=Auth::user()->id;
        $c=Company::findorfail($id);
        $count=0;


        foreach ($c->training_opps as $training_opp){
            $t = $training_opp->students()->get();
            $count=$count+$t->count();
        }
        return $count;

    }

    public function companyTrainingNumber(){
        $id=Auth::user()->id;

        return Company::findorfail($id)->training_opps()->count();

    }
}
