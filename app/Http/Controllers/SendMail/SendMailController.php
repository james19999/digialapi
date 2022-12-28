<?php

namespace App\Http\Controllers\SendMail;

use App\Models\Code;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\DIGITALSERVICES;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class SendMailController extends Controller
{

    //send mail
    public function sendemail (Request $request) {

        $users=$this->getUser_email($request->email);

        if ($users) {
            $code= $this->str_rancode();
            Code::create(['code'=>$code,'user_email'=>$users]);

            Mail::to($users)->send(new DIGITALSERVICES($users,$code));

            return Response::json([
                    'email' => $users,
                    "status"=>false,
            ]);
        }else{
            return Response::json([
                    'message' =>"email not found"
            ]);
        }
}

//verify code how you send to user
    public function verifycode(Request $request) {
         $userscode=$this->getUser_code($request->code);

          if($userscode==$request->code){
            return Response::json([
                 'codeverify'=>$userscode,
                 'status'=>false,
            ]);
          }else {
            return Response::json([
                'message'=>"bad code",
           ]);
          }
    }

//update password
    public function update (Request $request ,$user_email){
             try {
                 //code...
                 $user =User::where('email',$user_email)->get()->first();
                  if ($user) {
                      # code...
                      $user->password=Hash::make($request->password) ;
                      $user->save();
                    return Response::json([
                    "status"=>false,
                    "message"=>"success"
               ]);

                  }else{
                      return Response::json([
                           "message"=>"error updating"
                      ]);
                  }
             } catch (\Throwable $th) {
                return Response::json([
                    "message"=>$th->getMessage()
               ]);
             }

    }


public function getUser_email($email){
    $users=User::where('email',$email)->get();

      foreach($users as $user){
          return $user->email;
      }
}
public function getUser_code($code){
    $users=Code::where('code',$code)->get();

      foreach($users as $user){
          return $user->code;
      }
}


public function str_rancode($length=5){
    $c='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNSTUVWXYZ';
    return substr(str_shuffle($c),0,$length);
  }
}
