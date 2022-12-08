<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\SendMail\SendMailController;
use App\Http\Controllers\Api\Contrat\ContratController;
use App\Http\Controllers\Api\Services\ServiceController;
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

    Route::get('get/subscribption',[SubServiceController::class,'subscribptionlist']);


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

    Route::post('logout', [AdminController::class,'logout_user']);
    });

});
//code... contrat
Route::prefix('contrats')->group(function () {

   Route::post('create/contrat',[ContratController::class,'create_contrat']);

});
//code... réclamation
Route::prefix('reclamations')->group(function () {

   Route::post('create/reclamation',[ReclamationController::class,'create_reclamation']);

});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('link', function () {

    return Response::json([
        'tel'=>93266004,
        'telwha'=>'https://chat.whatsapp.com/INvSZoiQFpbB35B1apmBtg',
        'facebook'=>'http://www.gamil.com',
        'map'=>'http://www.gamil.com'
    ]);
});