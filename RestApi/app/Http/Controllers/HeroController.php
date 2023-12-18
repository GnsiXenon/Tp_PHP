<?php

namespace App\Http\Controllers;
use App\Models\HeroModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HeroController extends Controller
{
    public function getHero()
    {
        $superheros = DB::table('superheroes')->get(['name' , 'description']);

        if ($superheros->isEmpty()) {
            return response()->json([
                'code' => '404',
                'error' => 'No superheros found',
                'data' => ''
            ]);
        } else {
            return response()->json([
                'code' => '200',
                'data' => $superheros
            ]);
        }
    }

    public function createHero(Request $request)
    {
        //http://localhost:8000/createhero?name=banos&secret_identity=esteban&gender=f&hair_color=black&origin_planet=guezzland&description=guezz&group_id=0&vehicle_id=0
        $validatedData = $request->validate([
            'name' => 'required|string',
            'secret_identity' => 'required|string',
            'gender' => 'required|string',
            'hair_color' => 'required|string',
            'origin_planet' => 'required|string',
            'description' => 'required|string',
            'vehicle_id' => 'nullable',
            'group_id' => 'nullable',
        ]);

        // Adding created_at and updated_at with current timestamps
        $validatedData['created_at'] = now();
        $validatedData['updated_at'] = now();

        try {
            DB::table('superheroes')->insert($validatedData);
            return response()->json([
                'code' => '201',
                'msg' => 'Hero created successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => '500',
                'error' => 'Internal error',
                'tkt' => $e
            ]);
        }
    }
}
