<?php

namespace App\Http\Controllers;
use App\Models\HeroModel;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    public function getHero()
    {
        // Logique pour gérer la requête de cet endpoint
        return response()->json([
            'banos' => 'guezz'
        ]);
    }
    public function createHero(Request $request)
    {
        #$data = $request->input("test");
        #return response()->json([
        #    'banos' => "${data}"
        #]);
        $name = [$request->input("name")];
        HeroModel::create($name);
        return response()->json([
            'code' => '200'
        ]);
    }
}
