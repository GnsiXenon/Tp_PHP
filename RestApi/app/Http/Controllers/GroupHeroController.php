<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupHeroController extends Controller
{
    public function addGroupHero(Request $request)
    {
        if ((new ApiController)->readHeaderCookie()[0] == false) {
            return response()->json([
                'code' => (new ApiController)->readHeaderCookie()[1],
                'error' => (new ApiController)->readHeaderCookie()[2]
            ]);
        }
        $validatedData = $request->validate([
            'superhero_id' => 'required',
            'group_id' => 'required',
        ]);

        $check = DB::table('superheroes')
        ->where('id', '=', $validatedData['superhero_id'])
        ->get();
        if (count($check) == 0) {
            return response()->json([
                'code' => '400',
                'msg' => 'The hero does not exist'
            ]);
        }

        $check = DB::table('groups')
        ->where('id', '=', $validatedData['group_id'])
            ->get();
        if (count($check) == 0) {
            return response()->json([
                'code' => '400',
                'msg' => 'The group does not exist'
            ]);
        }

        $groupName = DB::table('groups')
            ->where('id', '=', $validatedData['group_id'])
            ->value('name');
        
        $heroName = DB::table('superheroes')
            ->where('id', '=' ,$validatedData['superhero_id'])
            ->value('name');


        //check if the hero id in the database already has the power
        $check = DB::table('superhero_group')
            ->where('superhero_id', '=', $validatedData['superhero_id'])
            ->where('group_id', '=', $validatedData['group_id'])
            ->get();
        
        if (count($check) > 0) {
            return response()->json([
                'code' => '400',
                'msg' => 'The'. $heroName . ' already has this'. $groupName
            ]);
        }
         try {
            DB::table('superhero_group')->insert($validatedData);
            return response()->json([
                'code' => '201',
                'msg' => $groupName . ' added to the hero ' . $heroName . ' successfully'
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

    public function deleteGroupHero(Request $request)
    {
        if ((new ApiController)->readHeaderCookie()[0] == false) {
            return response()->json([
                'code' => (new ApiController)->readHeaderCookie()[1],
                'error' => (new ApiController)->readHeaderCookie()[2]
            ]);
        }
        $validatedData = $request->validate([
            'superhero_id' => 'required',
            'group_id' => 'required',
        ]);

        //check if the hero id in the database already has the power
        $check = DB::table('superhero_group')
            ->where('superhero_id', '=', $validatedData['superhero_id'])
            ->where('group_id', '=', $validatedData['group_id'])
            ->get();
        
        if (count($check) == 0) {
            return response()->json([
                'code' => '400',
                'msg' => 'The hero does not have this group'
            ]);
        }


        try {
            DB::table('superhero_group')
                ->where('superhero_id', '=', $validatedData['superhero_id'])
                ->where('group_id', '=', $validatedData['group_id'])
                ->delete();
            return response()->json([
                'code' => '200',
                'msg' => 'group deleted successfully from the hero'
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

    public function getGroupHero(Request $request)
    {
        if ((new ApiController)->readHeaderCookie()[0] == false) {
            return response()->json([
                'code' => (new ApiController)->readHeaderCookie()[1],
                'error' => (new ApiController)->readHeaderCookie()[2]
            ]);
        }
        $validatedData = $request->validate([
            'superhero_id' => 'required',
        ]);

        $check = DB::table('superheroes')
            ->where('id', '=', $validatedData['superhero_id'])
            ->get();
        if (count($check) == 0) {
            return response()->json([
                'code' => '400',
                'msg' => 'The hero does not exist'
            ]);
        }

        $heroName = DB::table('superheroes')
            ->where('id', '=', $validatedData['superhero_id'])
            ->value('name');

        $groups = DB::table('superhero_group')
            ->where('superhero_id', '=', $validatedData['superhero_id'])
            ->join('groups', 'superhero_group.group_id', '=', 'groups.id')
            ->select('groups.name')
            ->get();

        return response()->json([
            'code' => '200',
            'msg' => 'The group of the hero ' . $heroName . ' are:',
            'powers' => $groups
        ]);
    }
    
}
