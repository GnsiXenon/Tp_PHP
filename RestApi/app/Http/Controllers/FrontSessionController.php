<?php

namespace App\Http\Controllers;
use App\Models\HeroModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Closure;
use Symfony\Component\HttpFoundation\Response;

class FrontSessionController extends Controller
{

    public function createSession(Request $request) 
    {
        //Frontsession
        $Entry = explode(':', $request->input('email:psw'));
        $email = $Entry[0];
        $password = $Entry[1];
        $passworduser = "";
        $id = "";

        try {
            $user = DB::table('users')->where('email', $email)->first();
            $passworduser = $user->password;
            $id = $user->id;
        } catch (\Throwable $th) {
            return response()->json([
                'code' => '404',
                'message' => 'User not found'
            ]);
        }
        

        if (hash('sha256', $password) == $passworduser) {
            $token = $this->createFrontSession($id);
            return response()->json([
                'code' => '200',
                'message' => 'Token created',
                'auth token' => $token
            ]);
        } else {
            return response()->json([
                'code' => '500',
                'message' => 'Bad password',
                'api_token' => $password
            ]);
        }
    }
    // This 
    private function createFrontSession($user_id)
     {
        $token = $this->createCookie(40);
        // Stocker l'ID de l'utilisateur en session
         $validatedData = ([
                'user_id' => $user_id,
                'token' => $token,
         ]);
         DB::table('Frontsession')->insert($validatedData);
         return $token;
    }

    private function createCookie($length = 30) 
    {
         // We create a cookie
             $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
             $randomString = '';
             for ($i = 0; $i < $length; $i++) {
                 $randomString .= $characters[rand(0, strlen($characters) - 1)];
             }
             return $randomString;
    }
}

