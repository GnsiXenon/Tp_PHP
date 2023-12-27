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

// return all the routes possible

Route::get('/', function () {
     return response()->json([
            //return all routes possible
            'routes' => [
                'get' => [
                    '/banos',
                    '/gettask',
                    '/gethero',
                    '/getcity',
                    '/getgroup',
                    '/getvehicule',
                    '/getgadget',
                    '/getsuperpower',
                    '/getuser',
                    '/connect',
                ],
                'post' => [
                    '/createhero',
                    '/createtask',
                    '/createcity',
                    '/creategroup',
                    '/createvehicule',
                    '/creategadget',
                    '/createsuperpower',
                    '/createuser',
                ],
            ]
    ]);;
});

// Hero
Route::get('gethero',[HeroController::class , 'getHero']);
Route::post('createhero',[HeroController::class , 'createHero']);

// User
Route::get ('getuser',[UserController::class , 'getUser']);
Route::get('connect',[UserController::class , 'UserConnect']);
Route::post('createuser',[UserController::class , 'createUser']);
Route::get('checkSession',[UserController::class , 'CheckSession']);

// City 
Route::get('getcity',[CityController::class , 'getcity']);
Route::post('createcity',[CityController::class , 'createCity']);

// Group 
Route::get('getgroup',[GroupController::class , 'getGroup']);
Route::post('creategroup',[GroupController::class , 'createGroup']);

// Vehicule
Route::get('getvehicule',[VehiculeController::class , 'getVehicule']);
Route::post('createvehicule',[VehiculeController::class , 'createVehicule']);

// Gadget
Route::get('getgadget',[GadgetController::class , 'getGadget']);
Route::post('creategadget',[GadgetController::class , 'createGadget']);

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
