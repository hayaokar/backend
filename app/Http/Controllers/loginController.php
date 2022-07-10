<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\student;
use App\Models\User;
use App\Models\Company;
use http\Env\Response;
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
            $token=$result->createToken('mytoken')->plainTextToken;
            $request['id']=$result->id;
            if($request->role_id==1){

                $result=Student::create($request->all());
            }
            if($request->role_id==2){
                $result=Company::create($request->all());
            }
            $response=[
                'user'=>$result,
                'token'=>$token
            ];
            return response($response,201);
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
            $token=$user->createToken('mytoken')->plainTextToken;
            $id=$user->id;

            $role_id=$user->role_id;
            if($role_id==1){
                $user=Student::findorfail($id);
                return response()->json([
                    'token'=>$token,
                    'role'=>"student",
                    'user'=>$user
                ]);
            }

            elseif($role_id==2){
                $user=Company::findorfail($id);
                if($user->activated)
                {
                    return response()->json([
                        'token'=>$token,
                        'role'=>"company",
                        'user'=>$user
                    ]);
                }
                return response()->json([
                    'message'=>'the company is not activated'
                ],423);


            }
            elseif($role_id==3){
                return response()->json([
                    'token'=>$token,
                    'user'=>$user,
                    'role'=>"admin"
                ]);
            }

            }

        return response()->json([
            'message'=>'the provided user does not match our record'
        ],422);
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return [
            'message'=>'logged out'
        ];
    }

}
