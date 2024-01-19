<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PowerHeroController extends Controller
{
 
    public function addPowerHero(Request $request)
    {
        if ((new ApiController)->readHeaderCookie()[0] == false) {
            return response()->json([
                'code' => (new ApiController)->readHeaderCookie()[1],
                'error' => (new ApiController)->readHeaderCookie()[2]
            ]);
        }
        $validatedData = $request->validate([
            'superhero_id' => 'required',
            'superpower_id' => 'required',
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

        $check = DB::table('superpowers')
        ->where('id', '=', $validatedData['superpower_id'])
            ->get();
        if (count($check) == 0) {
            return response()->json([
                'code' => '400',
                'msg' => 'The power does not exist'
            ]);
        }

        $powerName = DB::table('superpowers')
            ->where('id', '=', $validatedData['superpower_id'])
            ->value('name');
        
        $heroName = DB::table('superheroes')
            ->where('id', '=' ,$validatedData['superhero_id'])
            ->value('name');


        //check if the hero id in the database already has the power
        $check = DB::table('superhero_superpower')
            ->where('superhero_id', '=', $validatedData['superhero_id'])
            ->where('superpower_id', '=', $validatedData['superpower_id'])
            ->get();
        
        if (count($check) > 0) {
            return response()->json([
                'code' => '400',
                'msg' => 'The 1heroName already has this power'
            ]);
        }
         try {
            DB::table('superhero_superpower')->insert($validatedData);
            return response()->json([
                'code' => '201',
                'msg' => $powerName . ' added to the hero ' . $heroName . ' successfully'
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

    public function deletePowerHero(Request $request)
    {
        if ((new ApiController)->readHeaderCookie()[0] == false) {
            return response()->json([
                'code' => (new ApiController)->readHeaderCookie()[1],
                'error' => (new ApiController)->readHeaderCookie()[2]
            ]);
        }
        $validatedData = $request->validate([
            'superhero_id' => 'required',
            'superpower_id' => 'required',
        ]);

        //check if the hero id in the database already has the power
        $check = DB::table('superhero_superpower')
            ->where('superhero_id', '=', $validatedData['superhero_id'])
            ->where('superpower_id', '=', $validatedData['superpower_id'])
            ->get();
        
        if (count($check) == 0) {
            return response()->json([
                'code' => '400',
                'msg' => 'The hero does not have this power'
            ]);
        }


        try {
            DB::table('superhero_superpower')
                ->where('superhero_id', '=', $validatedData['superhero_id'])
                ->where('superpower_id', '=', $validatedData['superpower_id'])
                ->delete();
            return response()->json([
                'code' => '200',
                'msg' => 'Power deleted successfully from the hero'
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

    public function getPowerHero(Request $request)
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

        $powers = DB::table('superpowers')
            ->join('superhero_superpower', 'superpowers.id', '=', 'superhero_superpower.superpower_id')
            ->where('superhero_superpower.superhero_id', '=', $validatedData['superhero_id'])
            ->select('superpowers.name')
            ->get();

        return response()->json([
            'code' => '200',
            'msg' => 'The powers of the hero ' . $heroName . ' are:',
            'powers' => $powers
        ]);
    }
    
}
