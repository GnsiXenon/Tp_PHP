<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\CityController;
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
Route::get  ('/gethero',[HeroController::class , 'getHero']);
Route::get  ('/createhero',[HeroController::class , 'createHero']);

// City 
Route::get  ('/getcity',[CityController::class , 'getcity']);
Route::get  ('/createcity',[CityController::class , 'createCity']);

