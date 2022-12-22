<?php

namespace App\Http\Controllers\Api\Projects;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{

    public function all_Projects(){
        try {
             $Projects =Project::with('usersdevs')->get();
             return Response::json(['Projects'=>$Projects]);
        } catch (\Throwable $th) {
        }
   }

   public function create_Projects(Request $request){
        $validator =Validator::make($request->all(),[
            'name'     =>'required',
            'description' =>'required',
            'costumer_id' =>'required',
            'date_start' =>'required|date',
        ]);

        try {
             if ($validator->fails()) {
                 return response()->json([
                     'status'=>false,
                     'message'=>$validator->getMessageBag(),
                 ]);
             }else{
                 Project::create(['name'=>$request->name,
                 'description'=>$request->description,
                 'date_start'=>$request->date_start,
                 'costumer_id'=>$request->costumer_id]);
                 return response()->json([
                  'status'=>true,
                  'message'=>'success',
              ]);
             }
        } catch (\Throwable $th) {
            //throw $th;
        }
   }
   public function update_Projects(Request $request,$id){
        $validator =Validator::make($request->all(),[
            'name'     =>'required',
            'description' =>'required',
            'costumer_id' =>'required',
            'date_start' =>'required|date',
        ]);

        try {
             if ($validator->fails()) {
                 return response()->json([
                     'status'=>false,
                     'message'=>$validator->getMessageBag(),
                 ]);
             }else{
                 $Projects=Project::findOrfail($id);
                  if($Projects){
                      $Projects->update(['name'=>$request->name,
                      'description'=>$request->description,
                      'date_start'=>$request->date_start,
                      'costumer_id'=>$request->costumer_id]);
                      return response()->json([
                       'status'=>true,
                       'message'=>'success',
                   ]);
                  }else{
                      return response()->json(['Message' =>'Projects not found']);
                  }

             }
        } catch (\Throwable $th) {
          return response()->json(['Message' =>'Projects not found','message'=>$th->getMessage()]);

        }
   }

   public function delete_Projects($id){

        try {
            //code...
          $Projects=Project::findOrfail($id);
          if($Projects){
              $Projects->delete($id);
              return response()->json(['Message' =>'Projects delete']);

          }
              else{
                  return response()->json(['Message' =>'Projects not found']);
              }

        } catch (\Throwable $th) {
          return response()->json(['Message' =>'Projects not found','message'=>$th->getMessage()]);

        }

   }


    public function AttachProjectToUserDev(Request $request, $id){
          try {
              //code...
              $Projects =Project::findOrfail($id);
              if($Projects){
                $Projects->usersdevs()->sync($request->user_id);
              }else{
            return response()->json(['Message' =>'Projects not found']);
              }
          } catch (\Throwable $th) {
            return response()->json(['Message' =>'Projects not found','message'=>$th->getMessage()]);

          }
    }

    public function changestatusproject(Request $request,$id){
        try {
            //code...
            $Projects =Project::findOrfail($id);
            if($Projects){
            $Projects->update(['status' =>$request->status]);
        return response()->json(['Message' =>"Projects status $Projects->status ",'status' =>true]);

            }else{
        return response()->json(['Message' =>'Projects not found']);
            }
        } catch (\Throwable $th) {
        return response()->json(['Message' =>'Projects not found','message'=>$th->getMessage()]);

        }
    }
    //end date projects
    public function projectenddate($id){
        try {
            //code...
            $Projects =Project::findOrfail($id);
            if($Projects){
                  if($Projects->status=='end'){
                      $Projects->update(['date_end' =>Carbon::now()]);
                   return response()->json(['Message' =>'success']);

                  }else{
                    return response()->json(['Message' =>'Change project status to end after set the date']);

                  }

            }else{
        return response()->json(['Message' =>'Projects not found']);
            }
        } catch (\Throwable $th) {
        return response()->json(['Message' =>'Projects not found','message'=>$th->getMessage()]);

        }
    }
}
