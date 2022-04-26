<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Photo;
use Illuminate\Http\Request;
use App\Models\Scholarship;
class AdminCountry extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries= Country::all();
        $data=array();
        foreach ($countries as $country){
            $d=array("id"=>$country->id,"name"=>$country->name,"photo"=>$country->photo ? "http://localhost//backEnd//public//".$country->photo->file : 'no flag');
            array_push($data,$d);

        }
        return json_encode($data);


        //return Country::all();;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input=$request->all();

        if($file=$request->file('photo_id')){

            $name=time(). $file->getClientOriginalName();

            $file->move('images',$name);

            $photo=Photo::create(['file'=>$name]);

            $input['photo_id']=$photo->id;


        }


        Country::create($input);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Country::findorfail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        $c=Country::findorfail($id);

        $input=$request->all();

        if($file=$request->file('photo_id')){

            $name=time(). $file->getClientOriginalName();

            $file->move('images',$name);

            $photo=Photo::create(['file'=>$name]);

            $input['photo_id']=$photo->id;


        }

        $c->update($input);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $c=Country::findorfail($id);

        if($c->photo_id){
            $photo_id=$c->photo_id;

            unlink(public_path() . $c->photo->file);
            Photo::findorfail($photo_id)->delete();
        }


        $c->delete();
    }
}
