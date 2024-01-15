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
        //http://localhost:8000/api/connect?id=1&password=flodagnas54
        $password = $request->input("password");
        $id = $request->input("id");
        $user = DB::table('users')->where('id', $id)->first();
        $passworduser = $user->password;
        $id = $user->id;

        if (hash('sha256', $password) === $passworduser) {
            $cookie = $this->createSession($id);
            return response()->json([
                'code' => '200',
                'message' => 'Password matched',
                'cookie' => $cookie
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
        //http://localhost:8000/api/createuser?name=banos&email=banoslose@gmail.com&password=flodagnas54
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
     //We create a session
     private function createSession($user_id)
     {
         // We delete the session if it already exists
         $this->deleteSession($user_id);
         // Stocker l'ID de l'utilisateur en session
         $validatedData = ([
                'user_id' => $user_id,
         ]);
         $validatedData['create_date'] = now();
         $expireDate = now()->addDays(60);
         $validatedData['expire_date'] = $expireDate;
         $cookie = $this->createCookie(30);
         $validatedData['cookie'] = $cookie;
         DB::table('session')->insert($validatedData);
         return $cookie;
     }
     public function CheckSession(Request $request)
     {
         //http://localhost:8000/api/checkSession?cookie=
        // We return the user id if the session is valid
         $cookie = $request->header("auth");
         $session = DB::table('session')->where('cookie', '=', $cookie)->first();
         if ($session) {
             $now = now();
             $expireDate = $session->expire_date;
             if ($now < $expireDate) {
                 return response()->json([
                     'code' => '201',
                     'msg' => 'Session valid',
                     'user_id' => $session->user_id
                 ]);
             } else {
                 deleteSession($session->user_id);
                 return response()->json([
                     'code' => '400',
                     'msg' => 'Session expired'
                 ]);
             }
         } else {
             return response()->json([
                 'code' => '400',
                 'msg' => 'Session not found'
             ]);
         }   
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
     public function deleteSession($user_id)
     {
         // We delete the session
         DB::table('session')->where('user_id', '=', $user_id)->delete();
}

}
