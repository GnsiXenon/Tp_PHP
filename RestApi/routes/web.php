<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\GadgetController;
use App\Http\Controllers\SuperPowerController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/banos', function () {
    return response()->json([
        'title' => 'banos',
        'description' => 'guezz'
    ]);
});


// Hero 


// City 
Route::get  ('/getcity',[CityController::class , 'getcity']);
Route::get  ('/createcity',[CityController::class , 'createCity']);

// Group 
Route::get  ('/getgroup',[GroupController::class , 'getGroup']);
Route::get  ('/creategroup',[GroupController::class , 'createGroup']);

// Vehicule
Route::get  ('/getvehicule',[VehiculeController::class , 'getVehicule']);
Route::get  ('/createvehicule',[VehiculeController::class , 'createVehicule']);

// Gadget
Route::get  ('/getgadget',[GadgetController::class , 'getGadget']);
Route::get  ('/creategadget',[GadgetController::class , 'createGadget']);

// SuperPower
Route::get  ('/getsuperpower',[SuperPowerController::class , 'getSuperPower']);
Route::get  ('/createsuperpower',[SuperPowerController::class , 'createSuperPower']);

// User
Route::get  ('/getuser',[UserController::class , 'getUser']);
Route::get  ('/createuser',[UserController::class , 'createUser']);
Route::get  ('/connect',[UserController::class , 'UserConnect']);

