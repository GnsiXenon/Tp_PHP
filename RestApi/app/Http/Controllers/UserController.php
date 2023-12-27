<?php

namespace App\Http\Controllers;
use App\Models\HeroModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getUser()
    {
        $users = DB::table('users')->get(['name' , 'email' , 'avatar']);

        if ($users->isEmpty()) {
            return response()->json([
                'code' => '404',
                'error' => 'No user found'
            ]);
        } else {
            return response()->json([
                'code' => '200',
                'data' => $users
            ]);
        }
    }
    public function UserConnect(Request $request)
    {
        $password = $request->input("password");
        $id = $request->input("id");
        $user = DB::table('users')->where('id', $id)->first();
        $passworduser = $user->password;

        if (hash('sha256', $password) === $passworduser) {
            return response()->json([
                'code' => '200',
                'message' => 'Password matched'
            ]);
        } else {
            return response()->json([
                'code' => '401',
                'message' => 'Password mismatch'
            ]);
        }
    }

    public function createUser(Request $request)
    {
        //http://localhost:8000/createuser?name=banos&email=banoslose@gmail.com&password=flodagnas54
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
            'remember_token' => 'nullable|string',
            'api_token' => 'nullable|string',
            'avatar' => 'nullable|string',
        ]);

        // Hash the password
        $validatedData['password'] = hash('sha256', $validatedData['password']);
        // Adding created_at and updated_at with current timestamps
        $validatedData['created_at'] = now();
        $validatedData['updated_at'] = now();

        try {
            DB::table('users')->insert($validatedData);
            return response()->json([
                'code' => '201',
                'msg' => 'User created successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => '500',
                'error' => 'Internal error',
            ]);
        }
    }
}