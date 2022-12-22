<?php

namespace App\Http\Controllers\Api\Costumers;

use App\Models\Costumer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CostumerController extends Controller
{
    public function all_costumers(){
        try {
             $Costumers =Costumer::orderby('created_at','DESC')->get();
             return Response::json(['Costumers'=>$Costumers]);
        } catch (\Throwable $th) {
        }
   }

   public function create_costumers(Request $request){
        $validator =Validator::make($request->all(),[
          'name' =>'required',
          'phone'=>'required|unique:costumers,phone',
          'address'=>'required',
          'city' =>'required',
        ]);

        try {
             if ($validator->fails()) {
                 return response()->json([
                     'status'=>false,
                     'message'=>$validator->getMessageBag(),
                 ]);
             }else{
                 Costumer::create(['name'=>$request->name,
                 'phone'=>$request->phone,
                 'email'=>$request->email,
                 'address'=>$request->address,
                 'city'=>$request->city]);
                 return response()->json([
                  'status'=>true,
                  'message'=>'success',
              ]);
             }
        } catch (\Throwable $th) {
            //throw $th;
        }
   }
   public function update_costumers(Request $request,$id){
        $validator =Validator::make($request->all(),[
          'name' =>'required',
          'phone'=>'required|unique:costumers,phone',
          'address'=>'required',
          'city' =>'required',
        ]);

        try {
             if ($validator->fails()) {
                 return response()->json([
                     'status'=>false,
                     'message'=>$validator->getMessageBag(),
                 ]);
             }else{
                 $Costumers=Costumer::findOrfail($id);
                  if($Costumers){
                      $Costumers->update(['name'=>$request->name,
                      'phone'=>$request->phone,
                      'email'=>$request->email,
                      'address'=>$request->address,
                      'city'=>$request->city]);
                      return response()->json([
                       'status'=>true,
                       'message'=>'success',
                   ]);
                  }else{
                      return response()->json(['Message' =>'Costumers not found']);
                  }

             }
        } catch (\Throwable $th) {
          return response()->json(['Message' =>'Costumers not found','message'=>$th->getMessage()]);

        }
   }

   public function delete_costumers($id){

        try {
            //code...
          $Costumers=Costumer::findOrfail($id);
          if($Costumers){
              $Costumers->delete($id);
              return response()->json(['Message' =>'Costumers delete']);

          }
              else{
                  return response()->json(['Message' =>'Costumers not found']);
              }

        } catch (\Throwable $th) {
          return response()->json(['Message' =>'Costumers not found','message'=>$th->getMessage()]);

        }

   }
}