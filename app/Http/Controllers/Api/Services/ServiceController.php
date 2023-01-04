<?php

namespace App\Http\Controllers\Api\Services;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    //return all with subservices
    public function all (){

        try {
            $Services= Service::with('subservices')->get();
            return Response::json(['Services'=>$Services]);

        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    //create a new service

     public function create (Request $request){

              try {
                $validator =Validator::make($request->all(),[
                    'name'=>'required|unique:services,name',
                    'img' =>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',

               ]);
               //code...
               if($validator->fails()){
                 return response()->json(['Message' =>$validator->getMessageBag()]);

               }else{
                if($request->file('img')){
                    $file= $request->file('img');
                    $filename= date('YmdHi').$file->getClientOriginalName();
                    $file-> move(public_path('images'), $filename);
                    // $data['image']= $filename;
                    Service::create(['name'=>$request->name ,'img'=>$filename]);
                    return response()->json(['Message' =>'service create']);
                }
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
                          'img' =>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                     ]);
             //code...
             if($validator->fails()){
               return response()->json(['Message' =>$validator->getMessageBag()]);

             }else{
                  $Services= Service::findOrfail($id);
                  if($request->file('img')){
                    $file= $request->file('image');
                    $filename= date('YmdHi').$file->getClientOriginalName();
                    $file-> move(public_path('images'), $filename);
                    // $data['image']= $filename;
                    $Services->update(['name'=>$request->name ,'img'=>$filename]);
                   return response()->json(['Message' =>'service update']);
                }
             }
         } catch (\Throwable $th) {
             //throw $th;
         }
     }

//delete service
     public function delete($id){

         try {
             $Services= Service::findOrfail($id);
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
}