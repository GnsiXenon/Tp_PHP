<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\PowerHeroController;
use App\Http\Controllers\CityHeroController;
use App\Http\Controllers\GadgetHeroController;
use App\Http\Controllers\GroupHeroController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\GadgetController;
use App\Http\Controllers\SuperPowerController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\FrontSessionController;

// return all the routes possible

Route::get('/', function () {
    return response()->json([
        'code' => '200',
        'data' => [
            'endpoints' => (new ApiController)->getAllEndpoints()
        ]
    ]);
});

// Hero
Route::get('heroes',[HeroController::class , 'getHero']);
Route::post('hero',[HeroController::class , 'createHero']);
Route::put('hero/{id}',[HeroController::class , 'updateHeroById']);
Route::delete('hero/{id}',[HeroController::class , 'deleteHeroById']);
Route::get('hero/{id}',[HeroController::class , 'getHeroById']);


// User
Route::get ('getuser',[UserController::class , 'getUser']);
Route::post('connect',[UserController::class , 'UserConnect']);
Route::post('createuser',[UserController::class , 'createUser']);
Route::get('checkSession',[UserController::class , 'CheckSession']);

// City 

Route::post('city',[CityController::class , 'createCity']);
Route::put('city/{id}',[CityController::class , 'updateCityById']);
Route::delete('city/{id}',[CityController::class , 'deleteCityById']);
Route::get('city/{id}',[CityController::class , 'getCityById']);


//cities --> get all cities
//city --> create a city / update a city by id / delete a city by id  / get a city by id

// Group 
Route::get('groups',[GroupController::class , 'getGroup']);
Route::post('group',[GroupController::class , 'createGroup']);
Route::put('group/{id}',[GroupController::class , 'updateGroupById']);
Route::delete('group/{id}',[GroupController::class , 'deleteGroupById']);
Route::get('group/{id}',[GroupController::class , 'getGroupById']);

//groups --> get all groups
//group --> create a group / update a group by id / delete a group by id  / get a group by id


// Vehicule
Route::get('vehicules',[VehiculeController::class , 'getVehicule']);
Route::post('vehicule',[VehiculeController::class , 'createVehicule']);
Route::put('vehicule/{id}',[VehiculeController::class , 'updateVehiculeById']);
Route::delete('vehicule/{id}',[VehiculeController::class , 'deleteVehiculeById']);
Route::get('vehicule/{id}',[VehiculeController::class , 'getVehiculeById']);

//Vehicules --> get all Vehicules
//Vehicule --> create a Vehicule / update a Vehicule by id / delete a Vehicule by id  / get a Vehicule by id

// Gadget
Route::get('gadgets',[GadgetController::class , 'getGadget']);
Route::post('gadget',[GadgetController::class , 'createGadget']);
Route::put('gadget/{id}',[GadgetController::class , 'updateGadgetById']);
Route::delete('gadget/{id}',[GadgetController::class , 'deleteGadgetById']);
Route::get('gadget/{id}',[GadgetController::class , 'getGadgetById']);

//Gadgets --> get all gadgets



// SuperPower
Route::get('superpowers',[SuperPowerController::class , 'getSuperPower']);
Route::post('superpower',[SuperPowerController::class , 'createSuperPower']);
Route::put('superpower/{id}',[SuperPowerController::class , 'updateSuperPowerById']);
Route::delete('superpower/{id}',[SuperPowerController::class , 'deleteSuperPowerById']);
Route::get('superpower/{id}',[SuperPowerController::class , 'getSuperPowerById']);


// Join table 

Route::post('addpowerhero',[PowerHeroController::class , 'addPowerHero']);
Route::delete('deletepowerhero',[PowerHeroController::class , 'deletePowerHero']);
Route::get('getpowerhero',[PowerHeroController::class , 'getPowerHero']);

Route::post('addcityhero',[CityHeroController::class , 'addCityHero']);
Route::delete('deletecityhero',[CityHeroController::class , 'deleteCityHero']);
Route::get('getcityhero',[CityHeroController::class , 'getCityHero']);

Route::post('addgadgethero',[GadgetHeroController::class , 'addGadgetHero']);
Route::delete('deletegadgethero',[GadgetHeroController::class , 'deleteGadgetHero']);
Route::get('getgadgethero',[GadgetHeroController::class , 'getGadgetHero']);

Route::post('addgrouphero',[GroupHeroController::class , 'addGroupHero']);
Route::delete('deletegrouphero',[GroupHeroController::class , 'deleteGroupHero']);
Route::get('getgrouphero',[GroupHeroController::class , 'getGroupHero']);


// Create a front end session
Route::get('createFrontSession',[FrontSessionController::class , 'createSession']);

Route::middleware('auth')->group(function () {
    Route::get('cities',[CityController::class , 'getcity']);
});

Route::post('test',[ApiController::class, 'readHeaderCookie']);