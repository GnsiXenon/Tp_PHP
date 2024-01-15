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


//heroes --> get all heroes
//hero --> create a hero / update a hero by id / delete a hero by id  / get a hero by id


// User
Route::get ('getuser',[UserController::class , 'getUser']);
Route::get('connect',[UserController::class , 'UserConnect']);
Route::post('createuser',[UserController::class , 'createUser']);
Route::get('checkSession',[UserController::class , 'CheckSession']);

// City 
Route::get('getcity',[CityController::class , 'getcity']);
Route::post('createcity',[CityController::class , 'createCity']);

//cities --> get all cities
//city --> create a city / update a city by id / delete a city by id  / get a city by id

// Group 
Route::get('getgroup',[GroupController::class , 'getGroup']);
Route::post('creategroup',[GroupController::class , 'createGroup']);

//groups --> get all groups
//group --> create a group / update a group by id / delete a group by id  / get a group by id


// Vehicule
Route::get('getvehicule',[VehiculeController::class , 'getVehicule']);
Route::post('createvehicule',[VehiculeController::class , 'createVehicule']);

//Vehicules --> get all Vehicules
//Vehicule --> create a Vehicule / update a Vehicule by id / delete a Vehicule by id  / get a Vehicule by id

// Gadget
Route::get('getgadget',[GadgetController::class , 'getGadget']);
Route::post('creategadget',[GadgetController::class , 'createGadget']);

//Gadgets --> get all gadgets



// SuperPower
Route::get('getsuperpower',[SuperPowerController::class , 'getSuperPower']);
Route::post('createsuperpower',[SuperPowerController::class , 'createSuperPower']);


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
