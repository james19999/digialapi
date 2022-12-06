<?php

namespace App\Http\Controllers\Api\SubServices;

use App\Models\SubService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class SubServiceController extends Controller
{
    //return all with subservices
    public function all (){

        try {
            $Services= SubService::all();
            return Response::json(['SubServices'=>$Services]);

        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    //create a new service

     public function create (Request $request){

              try {
                $validator =Validator::make($request->all(),[
                    'name'=>'required|unique:sub_services,name',
                    'service_id'=>'required',
               ]);
               //code...
               if($validator->fails()){
                 return response()->json(['Message' =>$validator->getMessageBag()]);

               }else{
                SubService::create(['name'=>$request->name ,'service_id'=>$request->service_id]);
                   return response()->json(['Message' =>'service create']);
               }
              } catch (\Throwable $th) {
                  //throw $th;
              }



     }
    //update a new service

     public function update (Request $request,$id){

         try {

                     $validator =Validator::make($request->all(),[
                          'name'=>'required',
                     ]);
             //code...
             if($validator->fails()){
               return response()->json(['Message' =>$validator->getMessageBag()]);

             }else{
                  $Services= SubService::findOrfail($id);

                  $Services->update(['name'=>$request->name]);
                 return response()->json(['Message' =>'service update']);
             }
         } catch (\Throwable $th) {
             //throw $th;
         }
     }

//delete service
     public function delete($id){

         try {
             $Services= SubService::findOrfail($id);
             if($Services){
                $Services->delete($id);
                return response()->json(['Message' =>'service delete']);
             }else{
                return response()->json(['Message' =>'service not found']);

             }
         } catch (\Throwable $th) {
             //throw $th;
         }
     }

     //subscribption
     public function subscribption(Request $request){


      $Users= Auth::user()->id;
      $User=User::findOrfail($Users);

   if($User){

       $User->subservices()->sync($request->sub_service_id);
       return response()->json(['Message' =>"success" ,'status'=>true,'data'=>$Users]);
   }else{
       return response()->json(['Message' =>"errors"]);

   }
          try {
              //code...
          } catch (\Throwable $th) {
              //throw $th;
          }


     }
    public function subscribptionlist(){
        $Users= User::findOrfail(2);

        foreach($Users->subservices as $usersub){


                      return $usersub->pivot;

        }
    }

}