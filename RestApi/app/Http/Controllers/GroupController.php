<?php

namespace App\Http\Controllers;
use App\Models\cities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public function getGroup()
    {
        $groups = DB::table('groups')->get(['name']);

        if ($groups->isEmpty()) {
            return response()->json([
                'code' => '404',
                'error' => 'No groups found'
            ]);
        } else {
            return response()->json([
                'code' => '200',
                'data' => $groups
            ]);
        }
    }

    public function createGroup(Request $request)
    {
    $name = $request->input("name");

    // Vérification si le nom est correct
        if ($this->isValid($name)) {
            $existinggroup = DB::table('groups')->where('name', $name)->first();

            if ($existinggroup) {
                return response()->json([
                'code' => '409',
                'error' => 'group already exists'
            ]);
        }

        $insert = DB::table('groups')->insert(['name' => $name]);
            
            if ($insert) {
                return response()->json([
                    'code' => '201',
                    'msg' => 'Group add successufuly'
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
