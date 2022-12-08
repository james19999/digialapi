<?php

namespace App\Http\Controllers\Api\Contrat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contrat;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ContratController extends Controller
{
    public function create_contrat(Request $request){
           $validator =Validator::make($request->all(),[
                 'user_id'=>'required',
           ]);

            if($validator->fails()){
                 return Response::json([
                      'status'=>true,
                      'errors'=>$validator->getMessageBag()
                 ]);
            }else{
                $code= $this->str_rancode();
                Contrat::create(['user_id'=>$request->user_id,'code_contrat'=>$request->code_contrat=$code]);

                return Response::json([
                     'status'=>false,
                     'message'=>'success',
                ]);
            }
        try {

        } catch (\Throwable $th) {
            //throw $th;
        }
    }




    public function str_rancode($length=4){
        $c='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNSTUVWXYZ';
        return substr(str_shuffle($c),0,$length);
      }
}
