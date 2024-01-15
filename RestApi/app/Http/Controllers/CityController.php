<?php

namespace App\Http\Controllers;
use App\Models\cities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
/**
 * @OA\Get( 
 *    path="/api/cities",
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
     * @OA\Get(
     * path="/api/city/{id}",
     * summary="Get a city by id",
     * tags={"City"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * @OA\Schema(
     * type="integer"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="A city"
     * ),
     * @OA\Response(
     * response=404,
     * description="City not found"
     * )
     * )
     * )
     * )
     */

    public function getCityById($id)
    {
        $city = DB::table('cities')->find($id);

        if ($city) {
            return response()->json([
                'code' => '200',
                'data' => $city
            ]);
        } else {
            return response()->json([
                'code' => '404',
                'error' => 'No city found'
            ]);
        }
    }

    /**
     * * @OA\Post(
 *  path="/api/city",
 * summary="Create a new city",
 * tags={"City"},
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


    /**
     * @OA\Put(
     * path="/api/city/{id}",
     * summary="Update a city",
     * tags={"City"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * @OA\Schema(
     * type="integer"
     * )
     * ),
     * @OA\RequestBody(
     * required=false,
     * description="example of the body request",
     * @OA\JsonContent(
     * @OA\Property(property="name", type="string", example="Nantes"),
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="City updated successfully"
     * ),
     * @OA\Response(
     * response=400,
     * description="Invalid name supplied"
     * ),
     * @OA\Response(
     * response=404,
     * description="City not found"
     * ),
     * @OA\Response(
     * response=500,
     * description="Internal error"
     * )
     * )
     * )
     * )
     * 
     */

    public function updateCityById(Request $request, $id)
    {
        // Payload Json
    $payload = json_decode(request()->getContent(), true);
    //recuperer le hero
    $hero = DB::table('cities')->find($id);

    if ($hero) {
        //on update le hero
        try {
            DB::table('cities')->where('id', '=', $id)->update($payload);
            return response()->json([
                'code' => '200',
                'msg' => 'City updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => '500',
                'error' => 'Internal error'
            ]);
        }
    } else {
        return response()->json([
            'code' => '404',
            'error' => 'No city found'
        ]);
    }

}

/**
 * @OA\Delete(
 * path="/api/city/{id}",
 * summary="Delete a city",
 * tags={"City"},
 * @OA\Parameter(
 * name="id",
 * in="path",
 * required=true,
 * @OA\Schema(
 * type="integer"
 * )
 * ),
 * @OA\Response(
 * response=200,
 * description="City deleted successfully"
 * ),
 * @OA\Response(
 * response=404,
 * description="City not found"
 * ),
 * @OA\Response(
 * response=500,
 * description="Internal error"
 * )
 * )
 * )
 * )
 * 
 */

public function deleteCityById($id)
{
    $city = DB::table('cities')->find($id);

    if ($city) {
        try {
            DB::table('cities')->where('id', '=', $id)->delete();
            return response()->json([
                'code' => '200',
                'msg' => 'City deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => '500',
                'error' => 'Internal error'
            ]);
        }
    } else {
        return response()->json([
            'code' => '404',
            'error' => 'No city found'
        ]);
    }
}


private function isValid($input)
{
    return strlen($input) > 0;
}
}
