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

    

    public function createHero(Request $request)
    {
        $userId = $request->input("userId");
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


//getHeroById

public function getHeroById($id)
{
    $superheros = DB::table('superheroes')->where('id', $id)->get(['name' , 'description']);

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

//updateHero

public function updateHeroById($id)
{


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

    //supprimer le hero



    




    }


}
