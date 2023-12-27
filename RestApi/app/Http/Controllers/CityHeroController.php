<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityHeroController extends Controller
{
    public function addCityHero(Request $request)
    {
        $validatedData = $request->validate([
            'superhero_id' => 'required',
            'city_id' => 'required',
        ]);

        $check = DB::table('superheroes')
        ->where('id', '=', $validatedData['superhero_id'])
        ->get();
        if (count($check) == 0) {
            return response()->json([
                'code' => '400',
                'msg' => 'The hero does not exist'
            ]);
        }

        $check = DB::table('cities')
        ->where('id', '=', $validatedData['city_id'])
            ->get();
        if (count($check) == 0) {
            return response()->json([
                'code' => '400',
                'msg' => 'The city does not exist'
            ]);
        }

        $cityName = DB::table('cities')
            ->where('id', '=', $validatedData['city_id'])
            ->value('name');
        
        $heroName = DB::table('superheroes')
            ->where('id', '=' ,$validatedData['superhero_id'])
            ->value('name');


        //check if the hero id in the database already has the power
        $check = DB::table('superhero_city')
            ->where('superhero_id', '=', $validatedData['superhero_id'])
            ->where('city_id', '=', $validatedData['city_id'])
            ->get();
        
        if (count($check) > 0) {
            return response()->json([
                'code' => '400',
                'msg' => 'The'. $heroName . ' already has this'. $cityName
            ]);
        }
         try {
            DB::table('superhero_city')->insert($validatedData);
            return response()->json([
                'code' => '201',
                'msg' => $cityName . ' added to the hero ' . $heroName . ' successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => '500',
                //show the error message
                'msg' => $e->getMessage(),
                'error' => 'Internal error'
            ]);
        }
    }

    public function deleteCityHero(Request $request)
    {
        $validatedData = $request->validate([
            'superhero_id' => 'required',
            'city_id' => 'required',
        ]);

        //check if the hero id in the database already has the power
        $check = DB::table('superhero_city')
            ->where('superhero_id', '=', $validatedData['superhero_id'])
            ->where('city_id', '=', $validatedData['city_id'])
            ->get();
        
        if (count($check) == 0) {
            return response()->json([
                'code' => '400',
                'msg' => 'The hero does not have this city'
            ]);
        }


        try {
            DB::table('superhero_city')
                ->where('superhero_id', '=', $validatedData['superhero_id'])
                ->where('city_id', '=', $validatedData['city_id'])
                ->delete();
            return response()->json([
                'code' => '200',
                'msg' => 'city deleted successfully from the hero'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => '500',
                //show the error message
                'msg' => $e->getMessage(),
                'error' => 'Internal error'
            ]);
        }
    }

    public function getCityHero(Request $request)
    {
        $validatedData = $request->validate([
            'superhero_id' => 'required',
        ]);

        $check = DB::table('superheroes')
            ->where('id', '=', $validatedData['superhero_id'])
            ->get();
        if (count($check) == 0) {
            return response()->json([
                'code' => '400',
                'msg' => 'The hero does not exist'
            ]);
        }

        $heroName = DB::table('superheroes')
            ->where('id', '=', $validatedData['superhero_id'])
            ->value('name');

        $cities = DB::table('superhero_city')
            ->join('cities', 'superhero_city.city_id', '=', 'cities.id')
            ->where('superhero_city.superhero_id', '=', $validatedData['superhero_id'])
            ->select('cities.name')
            ->get();

        return response()->json([
            'code' => '200',
            'msg' => 'The cities of the hero ' . $heroName . ' are:',
            'powers' => $cities
        ]);
    }
}
