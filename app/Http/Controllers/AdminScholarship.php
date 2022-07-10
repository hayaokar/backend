<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use App\Models\Scholarship;
class AdminScholarship extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $scholarships= Scholarship::all();
        $data=array();

        foreach ($scholarships as $scholarship){
            $d=array("id"=>$scholarship->id,
                "name"=>$scholarship->name,
                'country'=>$scholarship->country->name,
                'major'=>$scholarship->major,
                'target'=>$scholarship->target,
                'duration'=>$scholarship->duration,
                'conditions'=>$scholarship->conditions,
                'requirements'=>$scholarship->requirements,
                'type'=>$scholarship->type,
                'university'=>$scholarship->university_name ? : 'no university',
                'charity_name'=>$scholarship->charity_name ? : 'no charity',
                'url'=>$scholarship->url,
                "photo"=>$scholarship->photo ? "http://localhost//backEnd//public//".$scholarship->photo->file : 'no photo');
            array_push($data,$d);

        }
        return json_encode($data);
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


        Scholarship::create($input);


        return "true";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $scholarship=Scholarship::findorfail($id);
        $data=array();
        $d=array("id"=>$scholarship->id,
            "name"=>$scholarship->name,
            'country'=>$scholarship->country->name,
            'major'=>$scholarship->major,
            'target'=>$scholarship->target,
            'duration'=>$scholarship->duration,
            'conditions'=>$scholarship->conditions,
            'requirements'=>$scholarship->requirements,
            'type'=>$scholarship->type,
            'university'=>$scholarship->university_name ? : 'no university',
            'charity_name'=>$scholarship->charity_name ? : 'no charity',
            'url'=>$scholarship->url,
            "photo"=>$scholarship->photo ? "http://localhost//backEnd//public//".$scholarship->photo->file : 'no photo');
        array_push($data,$d);

        return json_encode($data);


        //        return Scholarship::findorfail($id);

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
        $s=Scholarship::findorfail($id);

        $input=$request->all();

        if($file=$request->file('photo_id')){

            $name=time(). $file->getClientOriginalName();

            $file->move('images',$name);

            $photo=Photo::create(['file'=>$name]);

            $input['photo_id']=$photo->id;


        }


        $s->update($input);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $s=Scholarship::findorfail($id);
        if($s->photo_id){
            $photo_id=$s->photo_id;

            unlink(public_path() . $s->photo->file);
            Photo::findorfail($photo_id)->delete();
        }

        $s->delete();
    }
}
