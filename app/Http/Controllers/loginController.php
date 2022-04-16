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
            $name=$user->name;

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
        auth()->user()->tokens()->delete();

        return [
            'message'=>'logged out'
        ];
    }

}
