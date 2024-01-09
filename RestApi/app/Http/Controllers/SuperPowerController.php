<?php

namespace App\Http\Controllers;
use App\Models\HeroModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuperPowerController extends Controller
{

    /**
     * @OA\Get(
     * path="/api/getsuperpower",
     * summary="Get list of superpowers",
     * tags={"SuperPower"},
     * @OA\Response(
     *      response=200,
     *      description="A list with superpowers",
     *      @OA\JsonContent()
     * ),
     * @OA\Response(
     *      response=404,
     *      description="No superpowers found",
     *      @OA\JsonContent()
     *  )
     * )
     */

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

    /**
     * @OA\Post(
     *  path="/api/createsuperpower",
     * summary="Create a new superpower",
     * tags={"SuperPower"},
     * @OA\Parameter(
     *  name="name",
     * in="query",
     * required=true,
     * @OA\Schema(
     * type="string"
     * )
     * ),
     * @OA\RequestBody(
     *  required=false,
     * description="example of the body request",
     * @OA\JsonContent(
     * @OA\Property(property="name", type="string", example="SuperSpeed"),
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="SuperPower created successfully"
     * ),
     * @OA\Response(
     * response=400,
     * description="Invalid name supplied"
     * ),
     * @OA\Response(
     * response=409,
     * description="SuperPower already exists"
     * ),
     * @OA\Response(
     * response=500,
     * description="Internal error"
     * )
     * )
     * )
     * 
     * 
     */

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
