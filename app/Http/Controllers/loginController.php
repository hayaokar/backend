<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\student;
use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class loginController extends Controller
{

    public function register(UserRequest $request){
        try{
            $request['password']=Hash::make($request->password);
            $result=User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'role_id'=>$request->role_id,
                'password'=>$request->password,
            ]);
            $request['id']=$result->id;
            if($request->role_id==1){

                if($file=$request->file('certificates')) {


                    $name = time() . $file->getClientOriginalName();

                    $file->move('studentsCertificates', $name);

                    $request['certificates'] = $name;


                }



                Student::create($request->all());
            }
            if($request->role_id==2){
                Company::create($request->all());
            }
            return $result;
        }
        catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                return response()->json([
                    'message'=>'the email already taken'
                ],421);
            }
            return $e;

        }


    }

    public function login(Request $request){
        $credentials = [
            'email' => $request['email'],
            'password' => $request['password'],
        ];
        if(Auth::attempt($credentials)){
            $user=Auth::user();
            $token=md5(time()).'.'.md5($request->email);
            $name=$user->name;
            $user->forceFill([
                'remember_token'=>$token,
            ])->save();
            $role_id=$user->role_id;
            if($role_id==1){
                return response()->json([
                    'token'=>$token,
                    'name'=>$name,
                    'role'=>"student"
                ]);
            }

            elseif($role_id==2){
                $id = $user->id;
                if(Company::findorfail($id)->activated)
                {
                    return response()->json([
                        'token'=>$token,
                        'name'=>$name,
                        'role'=>"company"
                    ]);
                }
                return response()->json([
                    'message'=>'the company is not activated'
                ],423);


            }
            elseif($role_id==3){
                return response()->json([
                    'token'=>$token,
                    'name'=>$name,
                    'role'=>"admin"
                ]);
            }

            }

        return response()->json([
            'message'=>'the provided user does not match our record'
        ],422);
    }

    public function logout(Request $request){
        $request->user()->forceFill([
            'remember_token'=>null,
        ])->save();
        return response()->json(['message'=>'success']);
    }









}
