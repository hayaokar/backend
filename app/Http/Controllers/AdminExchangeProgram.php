<?php

namespace App\Http\Controllers;

use App\Models\exchange_program;
use App\Models\university;
use Illuminate\Http\Request;
use function Sodium\add;

class AdminExchangeProgram extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result=array();
        $e  = Exchange_program::all();

        foreach ($e as $item){
            $u=$item->universities;
            $u1=$u[0];
            $u2=$u[1];
            $a=array(
                'id'=>$item->id,
                'name'=>$item->name,
                //'number_of_students'=>$item->number_of_students,
                'details'=>$item->details,
                'university 1'=>$u1->name,
                'university 2'=>$u2->name

            );
            array_push($result,$a);
        }

        $result=json_encode($result);
        return $result;



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
        $e= exchange_program::create($request->all());
        $u1=university::findorfail($request['id1']);
        $u2=university::findorfail($request['id2']);
        $e->universities()->save($u1);
        $e->universities()->save($u2);




    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return exchange_program::findorfail($id);
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
        $e=exchange_program::findorfail($id);
        $e->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $e=exchange_program::findorfail($id);

        $e->universities()->detach();

        $e->delete();
    }
}
