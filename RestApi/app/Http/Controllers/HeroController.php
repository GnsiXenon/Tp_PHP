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
     *      path="/api/heroes",
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
        $superheros = DB::table('superheroes')->get(['id','name']);

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
     *     path="/api/hero",
     *    tags={"Hero"},
     *   summary="Create a new hero",
     *  description="Create a new hero",
     * operationId="createHero",
     * 
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
            //appel de la fonction readHeaderCookie dans le controller ApiController
       if ((new ApiController)->readHeaderCookie()[0] == false) {
        return response()->json([
            'code' => (new ApiController)->readHeaderCookie()[1],
            'error' => (new ApiController)->readHeaderCookie()[2]
        ]);
    }else{
        $userId = (new ApiController)->readHeaderCookie()[1];
    }
        // $userId = $request->input("userId");
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
            $newId = DB::getPdo()->lastInsertId();
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


//getHeroById

/**
 * @OA\Get(
 *     path="/api/hero/{id}",
 *  tags={"Hero"},
 * summary="Get a hero",
 * description="Get a hero",
 * operationId="getHeroById",
 * parameters={
 *  {
 * "name": "id",
 * "in": "path",
 * "description": "Id of the hero to get",
 * "required": true,
 * "type": "integer"
 * }
 * },
 * @OA\Response(
 *  response=200,
 * description="Hero found",
 * @OA\JsonContent(
 * @OA\Property(property="code", type="string", example="200"),
 *  @OA\Property(property="data", type="array", @OA\Items(type="string", example="Hero1")),
 * )
 * ),
 * @OA\Response(
 * response=404,
 * description="No hero found",
 * @OA\JsonContent(
 * @OA\Property(property="code", type="string", example="404"),
 * @OA\Property(property="error", type="string", example="No hero found"),
 * )
 * )
 * )
 * )
 * 
 */

public function getHeroById($id)
{
    $superhero = DB::table('superheroes')->find($id, ['id', 'name', 'description', 'secret_identity', 'gender', 'hair_color', 'origin_planet', 'description']);

    // Vérifier si le superhéros existe
    if ($superhero) {
        // Check si l'id est dans la table superheroes_city et si oui, on recupere toutes les cities associées
        $cities = DB::table('superhero_city')->where('superhero_id', '=', $id)->get(['city_id']);
        $citiesId = [];
        foreach ($cities as $city) {
            $citiesId[] = $city->city_id;
        }
        $superhero->cities = DB::table('cities')->whereIn('id', $citiesId)->get(['id', 'name']);
        // Check si l'id est dans la table superheroes_group et si oui, on recupere tous les groupes associés
        $groups = DB::table('superhero_group')->where('superhero_id', '=', $id)->get(['group_id']);
        $groupsId = [];
        foreach ($groups as $group) {
            $groupsId[] = $group->group_id;
        }
        $superhero->groups = DB::table('groups')->whereIn('id', $groupsId)->get(['id', 'name']);
        // Check si l'id est dans la table superheroes_superpower et si oui, on recupere tous les superpouvoirs associés
        $superpowers = DB::table('superhero_superpower')->where('superhero_id', '=', $id)->get(['superpower_id']);
        $superpowersId = [];
        foreach ($superpowers as $superpower) {
            $superpowersId[] = $superpower->superpower_id;
        }
        $superhero->superpowers = DB::table('superpowers')->whereIn('id', $superpowersId)->get(['id', 'name']);
        // Check si l'id est dans la table superheroes_gadget et si oui, on récupère le gadget associé
        $gadget = DB::table('superhero_gadget')->where('superhero_id', '=', $id)->get(['gadget_id']);
        $gadgetId = [];
        foreach ($gadget as $gadget) {
            $gadgetId[] = $gadget->gadget_id;
        }
        $superhero->gadgets = DB::table('gadgets')->whereIn('id', $gadgetId)->get(['id', 'name']);
        // Check si l'id est dans la table superheroes_vehicle et si oui, on récupère le véhicule associé
        $vehicle = DB::table('superhero_vehicle')->where('superhero_id', '=', $id)->get(['vehicle_id']);
        $vehicleId = [];
        foreach ($vehicle as $vehicle) {
            $vehicleId[] = $vehicle->vehicle_id;
        }
        $superhero->vehicles = DB::table('vehicles')->whereIn('id', $vehicleId)->get(['id', 'name']);
        
      
    } else {
        return response()->json([
            'code' => '404',
            'error' => 'No hero found',
            'data' => ''
        ]); 
    }

    return response()->json([
        'code' => '200',
        'data' => $superhero
    ]);
}

/**
 * @OA\Put(
 *    path="/api/hero/{id}",
 *  tags={"Hero"},
 * summary="Update a hero",
 * description="Update a hero",
 * operationId="updateHero",
 *  parameters={
 *  {
 * "name": "id",
 * "in": "path",
 * "description": "Id of the hero to get",
 * "required": true,
 * "type": "integer"
 * }
 * },
 * @OA\RequestBody(
 * required=false,
 * description="example of the body request",
 * @OA\JsonContent(
* @OA\Property(property="name", type="string", example="banos"),
* @OA\Property(property="secret_identity", type="string", example="banos2"),
* @OA\Property(property="gender", type="string", example="male"),
* @OA\Property(property="hair_color", type="string", example="black"),
* @OA\Property(property="origin_planet", type="string", example="guezzland"),
* @OA\Property(property="description", type="string", example="guezz"),
*
* )
* ),
*
* @OA\Response(
* response=200,
* description="Hero updated successfully",
* @OA\JsonContent(
* @OA\Property(property="code", type="string", example="200"),
* @OA\Property(property="msg", type="string", example="Hero updated successfully")
* )
* ),
*
* @OA\Response(
* response=404,
* description="No hero found",
* @OA\JsonContent(
* @OA\Property(property="code", type="string", example="404"),
* @OA\Property(property="error", type="string", example="No hero found"),
* )
* )
* )
* )
 */

public function updateHeroById($id)
{
    // Payload Json
    $payload = json_decode(request()->getContent(), true);
    //recuperer le hero
    $hero = DB::table('superheroes')->find($id);

    if ($hero) {
        //on update le hero
        try {
            DB::table('superheroes')->where('id', '=', $id)->update($payload);
            return response()->json([
                'code' => '200',
                'msg' => 'Hero updated successfully'
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
            'error' => 'No hero found'
        ]);
    }

}

/**
 * @OA\Delete(
 *     path="/api/hero/{id}",
 *   tags={"Hero"},
 *  summary="Delete a hero",
 * description="Delete a hero",
 * operationId="deleteHero",
 * parameters={
 *   {
 *     "name": "id",
 *    "in": "path",
 *  "description": "Id of the hero to delete",
 * "required": true,
 * "type": "integer"
 * }
 * },
 *  
 * @OA\Response(
 *  response=200,
 * description="Hero deleted successfully",
 * @OA\JsonContent(
 * @OA\Property(property="code", type="string", example="200"),
 * @OA\Property(property="msg", type="string", example="Hero deleted successfully")
 * )
 * 
 * ),
 * 
 * @OA\Response(
 * response=500,
 * description="Internal error",
 * @OA\JsonContent(
 * @OA\Property(property="code", type="string", example="500"),
 * @OA\Property(property="error", type="string", example="Internal error")
 * )
 * )
 * )
 * )
 * 
 * 
 */

//deleteHero

public function deleteHeroById($id)
{
   //delete hero by id
    try {
        DB::table('superhero_city')->where('superhero_id', '=', $id)->delete();
        DB::table('user_superhero')->where('superhero_id', '=', $id)->delete();
        DB::table('superhero_group')->where('superhero_id', '=', $id)->delete();
        DB::table('superhero_gadget')->where('superhero_id', '=', $id)->delete();
        DB::table('superhero_superpower')->where('superhero_id', '=', $id)->delete();
        DB::table('superheroes')->where('id', '=', $id)->delete();

        return response()->json([
            'code' => '',
            'msg' => 'Le hero a bien été delete'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'code' => '500',
            //show the error message
            'msg' => $e->getMessage(),
            'error' => 'Internal error'
        ]);
    }


    }

}
