<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
     public function getproducts (){

         try {
            $Products= Product::all();
              return response()->json(['Product'=>$Products]);
         } catch (\Throwable $th) {
            //throw $th;
         }
     }


     public function createproduct (Request $request){
               try {
                //code...
                $validate =Validator::make($request->all(),[
                     'titre'=>'required',
                     'description'=>'required',
                    'img' =>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                       
                ]);
                    if ($validate->fails()) {
                        
                        return response()->json(['Message' =>$validate->getMessageBag() ,'status'=>false]);
                    } else {
                          if($request->file('img')){
                          $file= $request->file('img');
                          $filename= date('YmdHi').$file->getClientOriginalName();
                           $file-> move(public_path('images'), $filename);
                         // $data['image']= $filename;
                            }
                         Product::create(['titre'=>$request->titre,'description'=>$request->description,'img'=>$filename]);
                         return response()->json(['Message' =>'success' ,'status'=>true]);
                         
                    }
                    
               } catch (\Throwable $th) {
                //throw $th;
               }
     }

     public function updateproduct (Request $request ,$id){
               try {
                //code...
                $validate =Validator::make($request->all(),[
                     'titre'=>'required',
                     'description'=>'required',
                     'img' =>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                       
                ]);
                    if ($validate->fails()) {
                        
                        return response()->json(['Message' =>$validate->getMessageBag() ,'status'=>false]);
                    } else {
                          if($request->file('img')){
                          $file= $request->file('img');
                          $filename= date('YmdHi').$file->getClientOriginalName();
                           $file-> move(public_path('images'), $filename);
                         // $data['image']= $filename;
                            }
                         $Products=Product::findOrfail($id);
                         $Products->update(['titre'=>$request->titre,'description'=>$request->description,'img'=>$filename]);   
                         return response()->json(['Message' =>'success' ,'status'=>true]);
                         
                    }
                    
               } catch (\Throwable $th) {
                //throw $th;
         }
     }


}
