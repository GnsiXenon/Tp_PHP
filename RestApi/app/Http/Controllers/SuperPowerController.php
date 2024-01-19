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
        if ((new ApiController)->readHeaderCookie()[0] == false) {
            return response()->json([
                'code' => (new ApiController)->readHeaderCookie()[1],
                'error' => (new ApiController)->readHeaderCookie()[2]
            ]);
        }
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
        if ((new ApiController)->readHeaderCookie()[0] == false) {
            return response()->json([
                'code' => (new ApiController)->readHeaderCookie()[1],
                'error' => (new ApiController)->readHeaderCookie()[2]
            ]);
        }
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

    /**
     * @OA\Put(
     * path="/api/superpower/{id}",
     * summary="Update a superpower",
     * tags={"SuperPower"},
     * @OA\Parameter(
     *      name="id",
     *      description="SuperPower id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *           type="integer",
     *           format="int64"
     *      )
     * ),
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
     * response=200,
     * description="SuperPower updated successfully"
     * ),
     * @OA\Response(
     * response=400,
     * description="Invalid name supplied"
     * ),
     * @OA\Response(
     * response=404,
     * description="SuperPower not found"
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

    public function updateSuperPowerById(Request $request, $id)
    {
        if ((new ApiController)->readHeaderCookie()[0] == false) {
            return response()->json([
                'code' => (new ApiController)->readHeaderCookie()[1],
                'error' => (new ApiController)->readHeaderCookie()[2]
            ]);
        }
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        try {
            $superpower = DB::table('superpowers')->where('id', $id)->first();
            if ($superpower) {
                DB::table('superpowers')->where('id', $id)->update($validatedData);
                return response()->json([
                    'code' => '200',
                    'msg' => 'SuperPower updated successfully'
                ]);
            } else {
                return response()->json([
                    'code' => '404',
                    'error' => 'SuperPower not found'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => '500',
                'error' => 'Internal error',
            ]);
        }
    }

    /**
     * @OA\Delete(
     * path="/api/superpower/{id}",
     * summary="Delete a superpower",
     * tags={"SuperPower"},
     * @OA\Parameter(
     *      name="id",
     *      description="SuperPower id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *           type="integer",
     *           format="int64"
     *      )
     * ),
     * 
     * @OA\Response(
     * response=200,
     * description="SuperPower deleted successfully"
     * ),
     * @OA\Response(
     * response=404,
     * description="SuperPower not found"
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
    public function deleteSuperPowerById($id)
    {
        if ((new ApiController)->readHeaderCookie()[0] == false) {
            return response()->json([
                'code' => (new ApiController)->readHeaderCookie()[1],
                'error' => (new ApiController)->readHeaderCookie()[2]
            ]);
        }
        try {
            $superpower = DB::table('superpowers')->where('id', $id)->first();
            if ($superpower) {
                DB::table('superpowers')->where('id', $id)->delete();
                return response()->json([
                    'code' => '200',
                    'msg' => 'SuperPower deleted successfully'
                ]);
            } else {
                return response()->json([
                    'code' => '404',
                    'error' => 'SuperPower not found'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => '500',
                'error' => 'Internal error',
            ]);
        }
    }

    /**
     * @OA\Get(
     * path="/api/superpower/{id}",
     * summary="Get a superpower by id",
     * tags={"SuperPower"},
     * @OA\Parameter(
     *      name="id",
     *      description="SuperPower id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *           type="integer",
     *           format="int64"
     *      )
     * ),
     * 
     * @OA\Response(
     * response=200,
     * description="A superpower",
     * @OA\JsonContent()
     * ),
     * @OA\Response(
     * response=404,
     * description="SuperPower not found",
     * @OA\JsonContent()
     *  )
     * )
     * )
     * 
     * 
     */

    public function getSuperPowerById($id)
    {
        if ((new ApiController)->readHeaderCookie()[0] == false) {
            return response()->json([
                'code' => (new ApiController)->readHeaderCookie()[1],
                'error' => (new ApiController)->readHeaderCookie()[2]
            ]);
        }
        try {
            $superpower = DB::table('superpowers')->where('id', $id)->first();
            if ($superpower) {
                return response()->json([
                    'code' => '200',
                    'data' => $superpower
                ]);
            } else {
                return response()->json([
                    'code' => '404',
                    'error' => 'SuperPower not found'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => '500',
                'error' => 'Internal error',
            ]);
        }
    }

}
