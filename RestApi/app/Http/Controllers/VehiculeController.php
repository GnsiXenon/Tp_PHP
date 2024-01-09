<?php

namespace App\Http\Controllers;
use App\Models\cities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehiculeController extends Controller
{
    /**
     * @OA\Get(
     *    path="/api/getvehicule",
     *   summary="Get a list of vehicule",
     *  tags={"Vehicule"},
     * @OA\Response(
     *   response=200,
     *  description="A list with vehicule",
     * @OA\JsonContent(
     * @OA\Property(property="code", type="integer", example=200),
     * @OA\Property(property="data", type="array", @OA\Items(type="string", example="Vehicule1")),
     * )
     * ),
     * @OA\Response(
     *  response=404,
     * description="No vehicule found",
     * @OA\JsonContent(
     * @OA\Property(property="code", type="integer", example=404),
     * @OA\Property(property="error", type="string", example="No vehicule found"),
     * )
     * )
     * )
     */
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

    /**
     * @OA\Post(
     *   path="/api/createvehicule",
     *  summary="Create a new vehicule",
     * tags={"Vehicule"},
     * @OA\Parameter(
     *  name="name",
     * description="Vehicule name",
     * required=true,
     * in="query",
     * @OA\Schema(
     * type="string"
     * )
     * ),
     * @OA\RequestBody(
     *   required=true,
     * @OA\JsonContent(
     * @OA\Property(property="name", type="string", example="Plane"),
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Vehicule created",
     * @OA\JsonContent(
     * @OA\Property(property="code", type="integer", example=201),
     * @OA\Property(property="msg", type="string", example="Vehicule created"),
     * )
     * ),
     * @OA\Response(
     * response=400,
     * description="Invalid name provided",
     * @OA\JsonContent(
     * @OA\Property(property="code", type="integer", example=400),
     * @OA\Property(property="error", type="string", example="Invalid name provided"),
     * )
     * ),
     * @OA\Response(
     * response=409,
     * description="Vehicule already exists",
     * @OA\JsonContent(
     * @OA\Property(property="code", type="integer", example=409),
     * @OA\Property(property="error", type="string", example="Vehicule already exists"),
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Internal error",
     * @OA\JsonContent(
     * @OA\Property(property="code", type="integer", example=500),
     * @OA\Property(property="error", type="string", example="Internal error"),
     * )
     * )
     * )
     * 
     */

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
