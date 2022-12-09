<?php

namespace App\Http\Controllers\Api\Reclamation;

use App\Mail\Contact;
use App\Models\Contrat;
use App\Models\Reclamation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

//create a new Contact

    public function create_contact(Request $request){
         try {
            $validator =Validator::make($request->all(),[
                'subject'=>'required',
                'msg'=>'required',
          ]);
             if ($validator->fails()) {
             return  Response::json(['status' =>false,'massage' =>$validator->getMessageBag()]);

             }else{

                 $user=Auth::user();

                 Mail::to('komlanahiakpor23@gmail.com')->send( new Contact($user->email,$user->name,$request->subject,$request->msg));
             }
             return  Response::json(['status' =>true,'massage' =>"success"]);

         } catch (\Throwable $th) {
             return  Response::json(['status' =>false,'massage' =>"$th"]);
         }
    }
}