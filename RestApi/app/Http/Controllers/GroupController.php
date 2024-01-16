<?php

namespace App\Http\Controllers;
use App\Models\cities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{

    /**
     * @OA\Get(
     *    path="/api/getgroup",
     *  summary="Get list of groups",
     * tags={"Group"},
     * @OA\Response(
     *  response=200,
     * description="A list with groups"
     * )
     * )
     */
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

    /**
     * @OA\Post(
     *   path="/api/creategroup",
     *  summary="Create a group",
     * tags={"Group"},
     * @OA\Parameter(
     *   description="Name of the group",
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
     *
     *  @OA\JsonContent(
     * 
     * @OA\Property(property="name", type="string", example="Avengers"),
     * 
     * 
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Group created"
     * ),
     * @OA\Response(
     * response=400,
     * description="Invalid input"
     * ),
     * @OA\Response(
     * response=409,
     * description="Group already exists"
     * )
     * )
     */

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

    /**
     * @OA\Put(
     *   path="/api/group/{id}",
     *  summary="Update a group",
     * tags={"Group"},
     * @OA\Parameter(
     *   description="ID of the group",
     *  in="path",
     * name="id",
     * required=true,
     * @OA\Schema(
     * type="integer"
     * )
     * ),
     * @OA\Parameter(
     *   description="Name of the group",
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
     *
     *  @OA\JsonContent(
     * 
     * @OA\Property(property="name", type="string", example="Avengers"),
     * 
     * 
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Group updated"
     * ),
     * @OA\Response(
     * response=400,
     * description="Invalid input"
     * ),
     * @OA\Response(
     * response=404,
     * description="Group not found"
     * )
     * )
     */

    public function updateGroupById(Request $request, $id)
    {
        $name = $request->input("name");

        if ($this->isValid($name)) {
            $existinggroup = DB::table('groups')->where('id', $id)->first();

            if ($existinggroup) {
                $update = DB::table('groups')->where('id', $id)->update(['name' => $name]);

                if ($update) {
                    return response()->json([
                        'code' => '200',
                        'msg' => 'Group updated successufuly'
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
                    'error' => 'Group not found'
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
     *   path="/api/group/{id}",
     *  summary="Delete a group",
     * tags={"Group"},
     * @OA\Parameter(
     *   description="ID of the group",
     *  in="path",
     * name="id",
     * required=true,
     * @OA\Schema(
     * type="integer"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Group deleted"
     * ),
     * @OA\Response(
     * response=404,
     * description="Group not found"
     * )
     * )
     */

    public function deleteGroupById($id)
    {
        $existinggroup = DB::table('groups')->where('id', $id)->first();

        if ($existinggroup) {
            $delete = DB::table('groups')->where('id', $id)->delete();

            if ($delete) {
                return response()->json([
                    'code' => '200',
                    'msg' => 'Group deleted successufuly'
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
                'error' => 'Group not found'
            ]);
        }
    }

    /**
     * @OA\Get(
     *   path="/api/group/{id}",
     *  summary="Get a group by id",
     * tags={"Group"},
     * @OA\Parameter(
     *   description="ID of the group",
     *  in="path",
     * name="id",
     * required=true,
     * @OA\Schema(
     * type="integer"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Group found"
     * ),
     * @OA\Response(
     * response=404,
     * description="Group not found"
     * )
     * )
     */

    public function getGroupById($id)
    {
        $existinggroup = DB::table('groups')->where('id', $id)->first();

        if ($existinggroup) {
            return response()->json([
                'code' => '200',
                'data' => $existinggroup
            ]);
        } else {
            return response()->json([
                'code' => '404',
                'error' => 'Group not found'
            ]);
        }
    }

    

    private function isValid($input)
    {
        return strlen($input) > 0;
    }

}
