<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\PowerHeroController;
use App\Http\Controllers\CityHeroController;
use App\Http\Controllers\GadgetHeroController;
use App\Http\Controllers\GroupHeroController;

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

Route::get('gethero',[HeroController::class , 'getHero']);
Route::post('createhero',[HeroController::class , 'createHero']);

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
