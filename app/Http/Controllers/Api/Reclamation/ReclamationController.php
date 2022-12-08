<?php

namespace App\Http\Controllers\Api\Reclamation;

use App\Models\Contrat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reclamation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ReclamationController extends Controller
{

    public function create_reclamation(Request $request){

        $validator =Validator::make($request->all(),[
            'content'=>'required',
            'contrat_id'=>'required',
      ]);

       if($validator->fails()){
            return Response::json([
                 'status'=>true,
                 'errors'=>$validator->getMessageBag()
            ]);
       }else{

             $Contrat =$this->get_code_contrat($request->contrat_id);

              if ($Contrat==$request->contrat_id){
                  Reclamation::create(['content'=>$request->content,'contrat_id'=>$Contrat]);
              }else{
                  return  Response::json(['message'=>"Code contrat invalide"]);
              }
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

  //return code_contrat in database
    public function get_code_contrat($code) {
        $Contrat =Contrat::where('code_contrat',$code)->get();

         foreach( $Contrat as  $Contra){
              return $Contra->code_contrat;
         }

    }
}
