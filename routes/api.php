<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Api\ProductController;
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
 //product
 
 Route::prefix('products')->group(function () {
 Route::get('get/product',[ProductController::class,'getproducts']);
 Route::post('create/product',[ProductController::class,'createproduct']);
 Route::post('update/product/{id}',[ProductController::class,'updateproduct']);
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
    $about =" Digital services est une entreprise spécialisée dans le développement des projets informatiques. Elle apporte des solutions informatiques aux entrepreneurs et les aide à mieux se positionner sur le marché. Digital Services c’est plus de compétences et de professionnalisme. Nous travaillons depuis nos débuts avec des valeurs d’intégrité et de confiance.

    Digital Services regroupe en son sein plusieurs compétences issues de diverses couches sociales et de divers domaines de compétence. Leur devise quotidienne est et demeure : « travail, passion et rigueur ».
    Nous fournissons depuis notre création des prestations en création et gestion de sites internet, la création et le développement d’applications mobile et web ; la conception des logiciels de gestion ; les services en infographie ; la maintenance informatique et la communication digitale.
    Nous mettons nos clients et nos partenaires au centre de nos projets et nous définissons nos objectifs d’après nos engagements réciproques.
    Nos experts s’assurent toujours du temps de livraison et de la qualité des rendus.
    Accompagnement
    Nous accompagnons les entreprises ayant des projets, et nous leur proposons et les aidons à y associer le volet informatique.
    Nous intervenons dans la vie des entreprises depuis leur naissance et nous participons activement à leur croissance.
    ";
    $adventage ="
    Nous utilisons pour chaque projet la technologie adaptée et ceci dans le respect des règles d’éthique et de déontologie. Nous essayons toujours d’impliquer nos clients sur les différentes phases des projets, et nous les rassurons en amont que leur projet seront exécutés efficacement tant d’un point de vue esthétique qu’ergonomique.
    Nous assurons aussi en surplus un pack d’avantages tels que répartis :

    -	Une garantie de sécurité et de maintenance de 1 mois sur chaque projet réalisé
    -	Nous garantissons la préservation du secret professionnel sur chaque projet réalisé, aussi bien en cours de son exécution et qu’à sa fin.
    -	Nous assurons l’hébergement des projets
    -	Chaque projet réalisé à droit à deux semaines de communication digitale
    -	Une adresse professionnelle est associée à chaque projet
    -	Nous affectons un nom de domaine gratuit à chaque projet web
    -	Nous prenons en charge les frais d’hébergement des applications sur Play store

    ";
    return Response::json([
        'tel'=>92212530,
        'tels'=>96698256,
        'telwha'=>'https://chat.whatsapp.com/INvSZoiQFpbB35B1apmBtg',
        'facebook'=>'http://www.gamil.com',
        'map'=>'http://www.gamil.com',
        'about'=>$about,
        'adventage '=>$adventage
    ]);
});
