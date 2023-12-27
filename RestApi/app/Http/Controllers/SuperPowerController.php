<?php

namespace App\Http\Controllers;
use App\Models\HeroModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuperPowerController extends Controller
{
    public function getSuperPower()
    {
        $superpowers = DB::table('superpowers')->get(['name']);

        if ($superpowers->isEmpty()) {
            return response()->json([
                'code' => '404',
                'error' => 'No superpower found'
            ]);
        } else {
            return response()->json([
                'code' => '200',
                'data' => $superpowers
            ]);
        }
    }

    public function createSuperPower(Request $request)
    {
        //http://localhost:8000/createhero?name=banos&secret_identity=esteban&gender=f&hair_color=black&origin_planet=guezzland&description=guezz&group_id=0&vehicle_id=0
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);


        try {
            DB::table('superpowers')->insert($validatedData);
            return response()->json([
                'code' => '201',
                'msg' => 'SuperPower created successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => '500',
                'error' => 'Internal error',
            ]);
        }
    }
}
