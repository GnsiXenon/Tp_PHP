<?php

namespace App\Http\Controllers;
use App\Models\cities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
/**
 * @OA\Get( 
 *    path="/api/getcity",
 *   summary="Get list of cities",
 *  tags={"City"},
 * @OA\Response(
 *   response=200,
 *  description="A list with cities"
 * )
 * )
 * 
 */

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

    /**
     * * @OA\Post(
 *  path="/api/createcity",
 * summary="Create a new city",
 * tags={"City"},
 * @OA\Parameter(
 *   name="name",
 *  in="query",
 * required=true,
 * @OA\Schema(
 *  type="string"
 * )
 * ),
 *@OA\RequestBody(
     *   required=false,
     * description="example of the body request",
     *  @OA\JsonContent(
     * @OA\Property(property="name", type="string", example="Nantes"),
     * )
     * ),
 * @OA\Response(
 *  response=201,
 * description="City created successfully"
 * ),
 * @OA\Response(
 * response=400,
 * description="Invalid name supplied"
 * ),
 * @OA\Response(
 * response=409,
 * description="City already exists"
 * ),
 * @OA\Response(
 * response=500,
 * description="Internal error"
 * )
 * )
 * )
 * )
 * */


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
        return strlen($input) > 0;
    }

}
