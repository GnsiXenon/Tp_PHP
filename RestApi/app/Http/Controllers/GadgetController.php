<?php

namespace App\Http\Controllers;
use App\Models\cities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GadgetController extends Controller
{
/**
 * @OA\Get(
 *    path="/api/getgadget",
 *  summary="Get list of gadgets",
 * tags={"Gadget"},
 * @OA\Response(
 *  response=200,
 * description="A list with gadgets"
 * )
 * )
 */
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

/**
 * @OA\Post(
 *   path="/api/creategadget",
 *  summary="Create a gadget",
 * tags={"Gadget"},
 * @OA\Parameter(
 *   description="Name of the gadget",
 *  in="query",
 * name="name",
 * required=true,
 * @OA\Schema(
 * type="string"
 * )
 * ),
* @OA\RequestBody(
*   required=false,
* description="example of the body request",
*  @OA\JsonContent(
* @OA\Property(property="name", type="string", example="Bow"),
* )
 * ),
 * @OA\Response(
 * response=201,
 * description="Gadget created"
 * ),
 * @OA\Response(
 * response=400,
 * description="Invalid input"
 * ),
 * @OA\Response(
 * response=409,
 * description="Gadget already exists"
 * ),
 * @OA\Response(
 * response=500,
 * description="Internal error"
 * )
 * )
 */

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

    /**
     * @OA\Put(
     *  path="/api/gadget/{id}",
     * summary="Update a gadget",
     * tags={"Gadget"},
     * @OA\Parameter(
     * description="ID of gadget to update",
     * in="path",
     * name="id",
     * required=true,
     * @OA\Schema(
     * type="integer"
     * )
     * ),
     * @OA\RequestBody(
     * required=false,
     * description="example of the body request",
     * @OA\JsonContent(
     * @OA\Property(property="name", type="string", example="grapplin"),
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Gadget updated"
     * ),
     * @OA\Response(
     * response=400,
     * description="Invalid input"
     * ),
     * @OA\Response(
     * response=404,
     * description="Gadget not found"
     * ),
     * @OA\Response(
     * response=500,
     * description="Internal error"
     * )
     * )
     * 
     */

    public function updateGadgetById(Request $request, $id)
    {
        $name = $request->input("name");

        if ($this->isValid($name)) {
            $existingGadget = DB::table('gadgets')->where('id', $id)->first();

            if ($existingGadget) {
                $update = DB::table('gadgets')->where('id', $id)->update(['name' => $name]);

                if ($update) {
                    return response()->json([
                        'code' => '200',
                        'msg' => 'Gadget updated'
                    ]);
                } else {
                    return response()->json([
                        'code' => '500',
                        'error' => 'Internal error'
                    ]);
                }
            } else {
                return response()->json([
                    'code' => '404',
                    'error' => 'Gadget not found'
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
     * @OA\Delete(
     *  path="/api/gadget/{id}",
     * summary="Delete a gadget",
     * tags={"Gadget"},
     * @OA\Parameter(
     * description="ID of gadget to delete",
     * in="path",
     * name="id",
     * required=true,
     * @OA\Schema(
     * type="integer"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Gadget deleted"
     * ),
     * @OA\Response(
     * response=404,
     * description="Gadget not found"
     * ),
     * @OA\Response(
     * response=500,
     * description="Internal error"
     * )
     * )
     */

    public function deleteGadgetById($id)
    {
        $gadget = DB::table('gadgets')->find($id);

        if ($gadget) {
            try {
                DB::table('gadgets')->where('id', '=', $id)->delete();
                return response()->json([
                    'code' => '200',
                    'msg' => 'Gadget deleted successfully'
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
                'error' => 'No gadget found'
            ]);
        }
    }

    /**
     * @OA\Get(
     *  path="/api/gadget/{id}",
     * summary="Get a gadget by ID",
     * tags={"Gadget"},
     * @OA\Parameter(
     * description="ID of gadget to return",
     * in="path",
     * name="id",
     * required=true,
     * @OA\Schema(
     * type="integer"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Gadget found"
     * ),
     * @OA\Response(
     * response=404,
     * description="Gadget not found"
     * ),
     * @OA\Response(
     * response=500,
     * description="Internal error"
     * )
     * )
     */

    public function getGadgetById($id)
    {
        $gadget = DB::table('gadgets')->find($id);

        if ($gadget) {
            return response()->json([
                'code' => '200',
                'data' => $gadget
            ]);
        } else {
            return response()->json([
                'code' => '404',
                'error' => 'No gadget found'
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
