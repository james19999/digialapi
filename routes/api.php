<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\SendMail\SendMailController;
use App\Http\Controllers\Api\Contrat\ContratController;
use App\Http\Controllers\Api\Projects\ProjectController;
use App\Http\Controllers\Api\Services\ServiceController;
use App\Http\Controllers\Api\Costumers\CostumerController;
use App\Http\Controllers\Api\SubServices\SubServiceController;
use App\Http\Controllers\Api\Reclamation\ReclamationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//service controller


Route::group(['prefix' => 'services'], function() {
    Route::post('create/service',[ServiceController::class,'create']);
    Route::get('get/service',[ServiceController::class,'all']);
    Route::put('update/service/{id}',[ServiceController::class,'update']);
    Route::delete('delete/service/{id}',[ServiceController::class,'delete']);
});

//subservice controller

Route::group(['prefix' => 'subservice'], function() {
    Route::get('get/service',[SubServiceController::class,'all']);
    Route::put('update/service/{id}',[SubServiceController::class,'update']);
    Route::delete('delete/service/{id}',[SubServiceController::class,'delete']);
    Route::post('create/service',[SubServiceController::class,'create']);

    Route::get('get/subscription/{id}',[SubServiceController::class,'subscriptionlist']);
    Route::get('get/subscriptions',[SubServiceController::class,'subscriptions']);


});

//email send controller
Route::prefix('emails')->group(function () {


    Route::post('email/create',[SendMailController::class,'sendemail']);
    Route::post('email/verifycode',[SendMailController::class,'verifycode']);
    Route::post('email/update/{user_email}',[SendMailController::class,'update']);


    });

//authantiked Controller
Route::prefix('authantiked')->group(function () {

    Route::post('register',[AdminController::class,'create_user']);
    Route::post('login',[AdminController::class,'login_user']);

    Route::middleware('auth:sanctum')->group(function () {

    Route::post('create/subscribption',[SubServiceController::class,'subscribption']);
    Route::post('create/email',[ReclamationController::class,'create_contact']);


    Route::post('logout', [AdminController::class,'logout_user']);



    });

});
//code... contrat
Route::prefix('contrats')->group(function () {

   Route::post('create/contrat',[ContratController::class,'create_contrat']);
   Route::post('attachesubservicetocontrat/contrat/{id}',[ContratController::class,'Attachesubservicetocontrat']);
   Route::get('show_contrat/contrat/{id}',[ContratController::class,'show_contrat']);

});
//code... réclamation
Route::prefix('reclamations')->group(function () {

   Route::post('create/reclamation',[ReclamationController::class,'create_reclamation']);

});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//admin routes for your application. These
 //code... costumers
Route::prefix('costumers')->group(function () {
 Route::get('get/costumer',[CostumerController::class,'all_costumers']);
 Route::post('create/costumer',[CostumerController::class,'create_costumers']);
 Route::put('update/costumer/{id}',[CostumerController::class,'update_costumers']);
 Route::delete('delete/costumer/{id}',[CostumerController::class,'delete_costumers']);

 });
 //code... projects
Route::prefix('projects')->group(function () {
 Route::get('get/project',[ProjectController::class,'all_projects']);
 Route::post('create/project',[ProjectController::class,'create_projects']);
 Route::put('update/project/{id}',[ProjectController::class,'update_projects']);
 Route::delete('delete/project/{id}',[ProjectController::class,'delete_projects']);
 Route::post('change/project/status/{id}',[ProjectController::class,'changestatusproject']);
 Route::post('attachprojecttouserdev/project/{id}',[ProjectController::class,'AttachProjectToUserDev']);
 Route::get('project/end/date/{id}',[ProjectController::class,'projectenddate']);

 });


//end admin routes for your application

Route::get('link', function () {

    return Response::json([
        'tel'=>92212530,
        'tels'=>96698256,
        'telwha'=>'https://chat.whatsapp.com/INvSZoiQFpbB35B1apmBtg',
        'facebook'=>'http://www.gamil.com',
        'map'=>'http://www.gamil.com'
    ]);
});
