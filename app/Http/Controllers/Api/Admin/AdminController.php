<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{



   public function create_user(Request $request) {


       $validate =Validator::make($request->all(),[
           'name' =>'required',
            'email' =>'required|email|unique:users,email',
            'password' =>'required',
            'personne' =>'required',
            'phone' =>'required|unique:users,phone',
       ]);
    try {
        //code...



         if($validate->fails()){

            return Response::json([
                 'status'=>false,
                 'message' =>$validate->getMessageBag(),
            ]);
         }else {
            $users=  User::create([
           'name'=>$request->name,
           'email'=>$request->email,
           'password'=>Hash::make($request->password),
           'phone'=>$request->phone,
           'personne'=>$request->personne,
        ]);
        return Response::json([
            'status'=>true,
            'message' =>"success",
            'user'=>$users,
       ]);

         }
    } catch (\Throwable $th) {
        //throw $th;
    }

   }

   public function login_user(Request $request) {

        try {
            //code...
            $Validator=Validator::make($request->all(),[
                // 'email'=>'required|email',
                'password'=>'required',

            ]);
             if ($Validator->fails()) {

                return Response::json([
                     'status'=>true,
                     'message'=>$Validator->getMessageBag(),
                ]);
             }else{
                  $user=User::where('email',$request->email)->orwhere('phone',$request->phone)->first();

                  if(! $user || ! Hash::check($request->password, $user->password)){
                    return response()->json([
                        'status'=>404,
                        'errors'=>'Vérifiez vos informations de connexion',
                    ]);
                  }else{
                    $token=$user->createToken($user)->plainTextToken;
                    return Response::json([
                        'status'=>false,
                        'message'=>"success",
                        'name'=>$user->name,
                        'email'=>$user->email,
                        'type'=>$user->type,
                        'phone'=>$user->phone,
                        'personne'=>$user->personne,
                        'id'=>$user->id,
                        'token'=>$token,
                   ]);
                  }
             }
        } catch (\Throwable $th) {
            //throw $th;
        }


   }

   public  function logout_user(Request $request){
    $logout=  $request->user()->currentAccessToken()->delete();

    try {
            if($logout){
                return Response::json([
                    'status'=>false,
                    "message"=>"success"
                ]);

            }else{
                return Response::json([
                    'status'=>true,
                    "message"=>"errors"
            ]);
            }
    } catch (\Throwable $th) {
        return Response::json([
            'status'=>true,
            "message"=>"$th"
    ]);
    }



   }
}