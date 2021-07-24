<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\HospitalsController;
use App\Http\Controllers\inquiriesController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ShuleApointController;
use App\Http\Controllers\DomicilieController;
use App\Http\Controllers\PDFScontroller;
use App\Http\Controllers\BloodPressureController;
use App\Http\Middleware\ApiAuthMiddleware;





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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::get('validar',[UserController::class,'validar']);
Route::post('login', [UserController::class,'authenticate']);
Route::post('google', [UserController::class,'LoginGoogle']);


Route::get('hospitals/count',[HospitalsController::class,'HospitalsCount']);
Route::get('inquiries/count',[inquiriesController::class,'count']);
Route::get('patients/count',[PatientsController::class,'count']);
Route::get('doctors/count',[DoctorsController::class,'count']);


// Route::group(['middleware' => ['api.auth']], function() {

    Route::post('hospitals',[HospitalsController::class,'create']);
    Route::put('hospitals/{uuid}',[HospitalsController::class,'updated']);
    Route::delete('hospitals/{uuid}',[HospitalsController::class,'delete']);
    Route::get('hospitals',[HospitalsController::class,'list']);
    Route::get('hospitals/{uuid}',[HospitalsController::class,'editar']);
    Route::post('hospitals/upload',[HospitalsController::class,'upload']);
    Route::get('hospitals/upload/{name}',[HospitalsController::class,'return_image']);
    
    Route::get('users/{uuid}',[UserController::class,'editar']);
    Route::put('users/{uuid}',[UserController::class,'updated']);
    Route::delete('users/{uuid}',[UserController::class,'delete']);
    Route::post('upload',[UserController::class,'upload']);
    Route::get('upload/{name}',[UserController::class,'return_image']);
    Route::post('users', [UserController::class,'register']);
    Route::get('users', [UserController::class,'list']);
    
    Route::post('patients', [PatientsController::class,'create']);
    Route::get('patients', [PatientsController::class,'list']);
    Route::get('patients/tratamient', [PatientsController::class,'listtratamient']);

  // Route::get('patients/{uuid}',[PatientsController::class,'editar']);
    Route::put('patients/{uuid}',[PatientsController::class,'updated']);
    Route::delete('patients/{uuid}',[PatientsController::class,'delete']);
    Route::post('patients/upload',[PatientsController::class,'upload']);
    Route::get('patients/upload/{name}',[PatientsController::class,'return_image']);
    Route::get('patients/bloquers', [PatientsController::class,'PatientsBloquers']);
    Route::get('restore/{uuid}',[PatientsController::class,'retornarPatients']);

    // 

    Route::post('doctors', [DoctorsController::class,'create']);
    Route::get('doctors', [DoctorsController::class,'list']);
    Route::get('doctors/delete', [DoctorsController::class,'DoctorsBloquers']);
    Route::get('doctors/{uuid}',[DoctorsController::class,'editar']);
    Route::put('doctors/{uuid}',[DoctorsController::class,'updated']);
    Route::delete('doctors/{uuid}',[DoctorsController::class,'delete']);
    Route::get('return/{uuid}',[DoctorsController::class,'retornarDoctor']);

    Route::post('doctors/upload',[DoctorsController::class,'upload']);
    Route::get('doctors/upload/{name}',[DoctorsController::class,'return_image']);
    // 


    Route::post('shedule',[ShuleApointController::class,'create']);
    Route::put('shedule/{uuid}',[ShuleApointController::class,'updated']);
    Route::delete('shedule/{uuid}',[ShuleApointController::class,'delete']);
    Route::get('shedule',[ShuleApointController::class,'list']);
    Route::get('shedule/{uuid}',[ShuleApointController::class,'editar']);
    
    Route::post('domicile',[DomicilieController::class,'create']);
    Route::put('domicile/{uuid}',[DomicilieController::class,'updated']);
    Route::delete('domicile/{uuid}',[DomicilieController::class,'delete']);
    Route::get('domicile',[DomicilieController::class,'list']);
    Route::get('domicile/{uuid}',[DomicilieController::class,'editar']);
    
    Route::post('inquiries',[inquiriesController::class,'create']);
    Route::put('inquiries/{uuid}',[inquiriesController::class,'updated']);
    Route::delete('inquiries/{uuid}',[inquiriesController::class,'delete']);
    Route::get('inquiries',[inquiriesController::class,'list']);
    Route::get('inquiries/{uuid}',[inquiriesController::class,'editar']);
    
    Route::post('recipe',[RecipeController::class,'create']);
    Route::put('recipe/{uuid}',[RecipeController::class,'updated']);
    Route::delete('recipe/{uuid}',[RecipeController::class,'delete']);
    Route::get('recipe',[RecipeController::class,'list']);
    Route::get('recipe/{uuid}',[RecipeController::class,'editar']);
    Route::get('recipe/pdf/{uuid}',[PDFScontroller::class,'receta']);
    Route::get('recipe/download/{uuid}',[PDFScontroller::class,'downloadReceta']);
    
    Route::post('blood',[BloodPressureController::class,'create']);
    Route::put('blood/{uuid}',[BloodPressureController::class,'updated']);
    Route::delete('blood/{uuid}',[BloodPressureController::class,'delete']);
    Route::get('blood',[BloodPressureController::class,'list']);
    Route::get('blood/{uuid}',[BloodPressureController::class,'editar']);
     
    Route::get('diet/pdf',[PDFScontroller::class,'dieta']);
    Route::get('diet/download/pdf',[PDFScontroller::class,'downloadieta']);
    Route::get('exp/pdf/{uuid}',[PDFScontroller::class,'expediente']);
    Route::get('exp/download/{uuid}',[PDFScontroller::class,'donwloadExpediente']);
    

    Route::get('roles',[RolesController::class,'list']);
// });
