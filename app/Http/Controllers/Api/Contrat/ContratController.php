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

     public function Attachesubservicetocontrat(Request $request,$id) {

         try {
             $Contrats=Contrat::findOrfail($id);
               if($Contrats){
                $Contrats->subservicescontract()->sync($request->sub_service_id);
                  return true;
               }else{
                   return false;
               }
             //code...
         } catch (\Throwable $th) {
             //throw $th;
         }
     }

     public function show_contrat($id){
         try {
            $Contrats =Contrat::findOrfail($id);
            if ($Contrats){
                return Response::json(['Contrat'=> $Contrats->with(['subservicescontract','costumer'])->get()]);

            }
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
     }


    public function str_rancode($length=4){
        $c='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNSTUVWXYZ';
        return substr(str_shuffle($c),0,$length);
      }
}
