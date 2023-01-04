<?php

namespace App\Http\Controllers\Api\SubServices;

use App\Models\User;
use App\Models\SubService;
use Illuminate\Http\Request;
use App\Mail\NewSubscription;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class SubServiceController extends Controller
{
    //return all with subservices
    public function all (){

        try {
            $Services= SubService::with('service')->get();
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
                    'img' =>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',

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
                    //    'img' =>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',

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
        // $explode = explode("," ,$request->sub_service_id);
        //   foreach($explode as $ex){
        // }
        $User->subservices()->sync($request->sub_service_id);
       Mail::to('komlanahiakpor23@gmail.com')->send(new NewSubscription($User->email,$User->name,$User->phone ));
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
   # get subservices
    public function getSubService($sub_id){
        $res = SubService::whereId($sub_id)->first();
        if ($res !== null) {
            return $res;
        }else {
            return null;
        }
    }
  # get subscription find by user
    public function subscriptionlist($user_id){
        $response = [];
        try {
            $user= User::where('id',$user_id)->first(); #verify if user exist, exist =true, continue
            $data = [];
            $subs = [];

            if ($user !== null) {
                # code...
                $services = $user->subservices;
                foreach($services as $service){
                    $res =  $service->pivot['sub_service_id'];
                    $ids = explode(',',$res); # séparer les ids
                    foreach ($ids as $key => $id) {
                        $sub = $this->getSubService($id);
                        $subs[] =$sub;
                    }
                }
                $data = [
                    'users' => $user,
                    'services' => $subs
                ];
                $response = [
                    'success'=>true,
                    'message'=>"success",
                    'result'=>$data
                ];
            }else{
                $response = [
                    'success'=>false,
                    'message'=>"user not found",
                    'result'=>null
                ];
            }



        } catch (\Throwable $th) {
            $response = [
                'success'=>false,
                'message'=>$th->getMessage(),
                'result'=>null
            ];
        }
        return response()->json($response);
    }

    public function subscriptions (){
        #ok
        $response = [];
        try {
            $users= User::orderby('created_at','DESC')->get(); #verify if user exist, exist =true, continue
            $data = [];
            $subs = [];

            foreach ($users as $key => $user) {
                # code...
                if ($user !== null) {
                    # code...
                    // $services = implode(",", $user->subservices);
                    $services = $user->subservices;
                    foreach($services as $service){
                        $res =  $service->pivot['sub_service_id'];
                       $ids = explode(',',$res); # séparer les ids
                        foreach ($ids as $key => $id) {

                             $sub = $this->getSubService($id);
                            $subs[] =$sub;
                        }
                    }
                    $data[] = [
                        'user' => $user,
                        'services' => $subs
                    ]; #là il recupere pour le last , donc pour eux tous, tu fais $data[] = ... donc pour chaque user, il va recuperer ses services

                }
            }
            $response = [
                'success'=>true,
                'message'=>"success",
                'result'=>$data
            ];

        } catch (\Throwable $th) {
            $response = [
                'errors'=>false,
                'message'=>$th->getMessage(),
                'result'=>null
            ];
        }
        return response()->json($response);
    }
}