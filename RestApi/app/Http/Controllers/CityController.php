<?php

namespace App\Http\Controllers;
use App\Models\cities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    public function getCity()
    {
        // Logique pour gérer la requête de cet endpoint
        return response()->json([
            'banos' => 'guezz'
        ]);
    }
    public function createCity(Request $request)
    {
        #$data = $request->input("test");
        #return response()->json([
        #    'banos' => "${data}"
        #]);
        $name = $request->input("name");
        $insert=DB::table('cities')->insert(['name' => $name]);
        if($insert) {
            return response()->json([
                'code' => '200'
            ]);
        }
            return response()->json([
                'code' => '000'
            ]);
        }
}
