<?php

namespace App\Http\Controllers;
use App\Models\HeroModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Info(
 *              title="Superhero API",
 *               version="0.1"
 * 
 * )
 * 
 * @OA\Server(url="http://localhost:8000")
 */


class HeroController extends Controller
{

    /**
     * @OA\Get(
     *      path="/api/gethero",
     *      operationId="getHero",
     *      tags={"Hero"},
     *      summary="Get list of superheros",
     *      description="Returns list of superheros",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="No superheros found",
     *          @OA\JsonContent()
     *       )
     *     )
     */

    public function getHero()
    {
        $superheros = DB::table('superheroes')->get(['name' , 'description']);

        if ($superheros->isEmpty()) {
            return response()->json([
                'code' => '404',
                'error' => 'No superheros found',
                'data' => ''
            ]);
        } else {
            return response()->json([
                'code' => '200',
                'data' => $superheros
            ]);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/createhero",
     *    tags={"Hero"},
     *   summary="Create a new hero",
     *  description="Create a new hero",
     * operationId="createHero",
     * parameters={
     *    {
     *       "name": "name",    
     *     "in": "query",
     *    "description": "Name of the hero",
     *   "required": true,
     * "type": "string"
     * },
     * {
     * "name": "secret_identity",
     * "in": "query",
     * "description": "Secret identity of the hero",
     * "required": true,
     * "type": "string"
     * },
     * {
     * "name": "gender",
     * "in": "query",
     * "descrition": "Gender of the hero",
     * "required": true,
     * "type": "string"
     * },
     * {
     * "name": "hair_color",
     * "in": "query",
     * "description": "Hair color of the hero",
     * "required": true,
     * "type": "string"
     * },
     * {
     * "name": "origin_planet",
     * "in": "query",
     * "description": "Origin planet of the hero",
     * "required": true,
     * "type": "string"
     * },
     * {
     * "name": "description",
     * "in": "query",
     * "description": "Description of the hero",
     * "required": true,
     * "type": "string"
     * },
     * {
     * "name": "userId",
     * "in": "query",
     * "description": "Id of the user who created the hero",
     * "required": true,
     * "type": "integer"
     * },
     * },
     * 
     *@OA\RequestBody(
     *   required=false,
     * description="example of the body request",
     *
     *  @OA\JsonContent(
     * 
     * @OA\Property(property="name", type="string", example="banos"),
     * @OA\Property(property="secret_identity", type="string", example="banos2"),
     * @OA\Property(property="gender", type="string", example="male"),
     * @OA\Property(property="hair_color", type="string", example="black"),
     * @OA\Property(property="origin_planet", type="string", example="guezzland"),
     * @OA\Property(property="description", type="string", example="guezz"),
     * @OA\Property(property="userId", type="integer", example="1"),
     * 
     * 
     * )
     * ),
     * 
     * @OA\Response(
     *    response=201,
     *   description="Hero created successfully",
     *  @OA\JsonContent(
     *    @OA\Property(property="code", type="string", example="201"),
     *  @OA\Property(property="msg", type="string", example="Hero created successfully")
     * )
     * ),
     * 
     * @OA\Response(
     *   response=500,
     * description="Internal error",
     * @OA\JsonContent(
     * @OA\Property(property="code", type="string", example="500"),
     * @OA\Property(property="error", type="string", example="Internal error")
     * )
     * )
     * )
     * )
     * 
     */

    public function createHero(Request $request)
    {
        $userId = $request->input("userId");
        //http://localhost:8000/createhero?name=banos&secret_identity=banos2&gender=m&hair_color=black&origin_planet=guezzland&description=guezz&group_id=0&vehicle_id=0&userId=4
        $validatedData = $request->validate([
            'name' => 'required|string',
            'secret_identity' => 'required|string',
            'gender' => 'required|string',
            'hair_color' => 'required|string',
            'origin_planet' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable',
            // 'vehicle_id' => 'nullable',
            // 'group_id' => 'nullable',
        ]);

        // Adding created_at and updated_at with current timestamps
        $validatedData['created_at'] = now();
        $validatedData['updated_at'] = now();

        try {
            DB::table('superheroes')->insert($validatedData);
            $newId = DB::table('superheroes')->insertGetId($validatedData);
            $linkdata = [
                'user_id' => $userId,
                'superhero_id' => $newId
            ];
            DB::table('user_superhero')->insert($linkdata);
            return response()->json([
                'code' => '201',
                'msg' => 'Hero created successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => '500',
                'error' => 'Internal error',
                'tkt' => $e
            ]);
        }
    }
}
