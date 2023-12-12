<?php

namespace App\Http\Controllers;

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
        $data = $request->input("test");
        return response()->json([
            'banos' => "${data}"
        ]);
    }
}
