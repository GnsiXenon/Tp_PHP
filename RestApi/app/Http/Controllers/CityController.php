<?php

namespace App\Http\Controllers;
use App\Models\cities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    public function getCity()
    {
        $cities = DB::table('cities')->get(['name']);

        if ($cities->isEmpty()) {
            return response()->json([
                'code' => '404',
                'error' => 'No cities found'
            ]);
        } else {
            return response()->json([
                'code' => '200',
                'data' => $cities
            ]);
        }
    }

    public function createCity(Request $request)
    {
    $name = $request->input("name");

    // Vérification si le nom est correct
        if ($this->isValid($name)) {
            $existingCity = DB::table('cities')->where('name', $name)->first();

            if ($existingCity) {
                return response()->json([
                'code' => '409',
                'error' => 'City already exists'
            ]);
        }

        $insert = DB::table('cities')->insert(['name' => $name]);
            
            if ($insert) {
                return response()->json([
                    'code' => '201',
                    'msg' => 'City add successufuly'
                ]);
            } else {
                return response()->json([
                    'code' => '500',
                    'error' => 'Internal error'
                ]);
            }
        } else {
            return response()->json([
                'code' => '400',
                'error' => 'Invalid name provided'
            ]);
        }
    }

    private function isValid($input)
    {
        // Vérification du nom ici
        // Vous pouvez ajouter votre logique de validation pour le nom
        // Par exemple, vérifier la longueur, les caractères autorisés, etc.
        // Pour cet exemple, supposons que le nom doit avoir au moins 3 caractères
        return strlen($input) > 0;
    }

}
