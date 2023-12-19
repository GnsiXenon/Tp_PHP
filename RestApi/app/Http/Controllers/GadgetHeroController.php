<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GadgetHeroController extends Controller
{
    public function addGadgetHero(Request $request)
    {
        $validatedData = $request->validate([
            'superhero_id' => 'required',
            'gadget_id' => 'required',
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

        $check = DB::table('gadgets')
        ->where('id', '=', $validatedData['gadget_id'])
            ->get();
        if (count($check) == 0) {
            return response()->json([
                'code' => '400',
                'msg' => 'The city does not exist'
            ]);
        }

        $gadgetName = DB::table('gadgets')
            ->where('id', '=', $validatedData['gadget_id'])
            ->value('name');
        
        $heroName = DB::table('superheroes')
            ->where('id', '=' ,$validatedData['superhero_id'])
            ->value('name');


        //check if the hero id in the database already has the power
        $check = DB::table('superhero_gadget')
            ->where('superhero_id', '=', $validatedData['superhero_id'])
            ->where('gadget_id', '=', $validatedData['gadget_id'])
            ->get();
        
        if (count($check) > 0) {
            return response()->json([
                'code' => '400',
                'msg' => 'The'. $heroName . ' already has this'. $gadgetName
            ]);
        }
         try {
            DB::table('superhero_gadget')->insert($validatedData);
            return response()->json([
                'code' => '201',
                'msg' => $gadgetName . ' added to the hero ' . $heroName . ' successfully'
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

    public function deleteGadgetHero(Request $request)
    {
        $validatedData = $request->validate([
            'superhero_id' => 'required',
            'gadget_id' => 'required',
        ]);

        //check if the hero id in the database already has the power
        $check = DB::table('superhero_gadget')
            ->where('superhero_id', '=', $validatedData['superhero_id'])
            ->where('gadget_id', '=', $validatedData['gadget_id'])
            ->get();
        
        if (count($check) == 0) {
            return response()->json([
                'code' => '400',
                'msg' => 'The hero does not have this gadget'
            ]);
        }


        try {
            DB::table('superhero_gadget')
                ->where('superhero_id', '=', $validatedData['superhero_id'])
                ->where('gadget_id', '=', $validatedData['gadget_id'])
                ->delete();
            return response()->json([
                'code' => '200',
                'msg' => 'gadget deleted successfully from the hero'
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

    public function getGadgetHero(Request $request)
    {
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

        $gadget = DB::table('superhero_gadget')
            ->where('superhero_id', '=', $validatedData['superhero_id'])
            ->join('gadgets', 'superhero_gadget.gadget_id', '=', 'gadgets.id')
            ->select('gadgets.name')
            ->get();

        return response()->json([
            'code' => '200',
            'msg' => 'The gadget of the hero ' . $heroName . ' are:',
            'powers' => $gadget
        ]);
    }
    }

