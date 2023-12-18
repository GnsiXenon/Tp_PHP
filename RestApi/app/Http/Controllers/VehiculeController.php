<?php

namespace App\Http\Controllers;
use App\Models\cities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehiculeController extends Controller
{
    public function getVehicule()
    {
        $Vehicule = DB::table('vehicles')->get(['name']);

        if ($Vehicule->isEmpty()) {
            return response()->json([
                'code' => '404',
                'error' => 'No vehicles found'
            ]);
        } else {
            return response()->json([
                'code' => '200',
                'data' => $Vehicule
            ]);
        }
    }

    public function createVehicule(Request $request)
    {
    $name = $request->input("name");

    // Vérification si le nom est correct
        if ($this->isValid($name)) {
            $existingVehicule = DB::table('vehicles')->where('name', $name)->first();

            if ($existingVehicule) {
                return response()->json([
                'code' => '409',
                'error' => 'Vehicle already exists'
            ]);
        }

        $insert = DB::table('vehicles')->insert(['name' => $name]);
            
            if ($insert) {
                return response()->json([
                    'code' => '201',
                    'msg' => 'Vehicle add successufuly'
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
