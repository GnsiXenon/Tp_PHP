<?php

namespace App\Http\Controllers;
use App\Models\cities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GadgetController extends Controller
{
    public function getGadget()
    {
        $gadget = DB::table('gadgets')->get(['name']);

        if ($gadget->isEmpty()) {
            return response()->json([
                'code' => '404',
                'error' => 'No gadgets found'
            ]);
        } else {
            return response()->json([
                'code' => '200',
                'data' => $gadget
            ]);
        }
    }

    public function createGadget(Request $request)
    {
    $name = $request->input("name");

    // Vérification si le nom est correct
        if ($this->isValid($name)) {
            $existingGadget = DB::table('gadgets')->where('name', $name)->first();

            if ($existingGadget) {
                return response()->json([
                'code' => '409',
                'error' => 'Gadget already exists'
            ]);
        }

        $insert = DB::table('gadgets')->insert(['name' => $name]);
            
            if ($insert) {
                return response()->json([
                    'code' => '201',
                    'msg' => 'Gadget add successufuly'
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
