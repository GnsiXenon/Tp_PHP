<?php

namespace App\Http\Controllers;
use App\Models\HeroModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
 
    /**
     * @OA\Get(
     * path="/api/getuser",
     * summary="Get all users",
     * tags={"User"},
     * @OA\Response(
     * response=200,
     * description="User found",
     * @OA\JsonContent(
     * @OA\Property(property="code", type="integer", example="200"),
     *  
     * )
     * ),
     * @OA\Response(
     * response=404,
     *  
     * description="No user found",
     * @OA\JsonContent(
     * @OA\Property(property="code", type="integer", example="404"),
     * @OA\Property(property="error", type="string", example="No user found"),
     * )
     * )
     * )
     * )
     */

    public function getUser()
    {
        $users = DB::table('users')->get(['name' ,'firstname', 'email' , 'avatar']);

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
    /**
     * @OA\Post(
     * path="/api/connect",
     * summary="Connect a user",
     * tags={"User"},
     * @OA\Parameter(
     * description="Password of the user",
     * in="query",
     * name="password",
     * 
     * @OA\Schema(
     * type="string"
     * )
     * ),
     * @OA\Parameter(
     * description="Id of the user",
     * in="query",
     * name="id",
     * 
     * @OA\Schema(
     * type="integer"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Password matched",
     * @OA\JsonContent(
     * @OA\Property(property="code", type="integer", example="200"),
     * @OA\Property(property="message", type="string", example="Password matched"),
     * @OA\Property(property="cookie", type="string", example=""),
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="Password mismatch",
     * @OA\JsonContent(
     * @OA\Property(property="code", type="integer", example="401"),
     * @OA\Property(property="message", type="string", example="Password mismatch"),
     * )
     * )
     * )
     * )
     *  
     * 
     */


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

    /**
     * @OA\Post(
     *  path="/api/createuser",
     * summary="Create a user",
     * tags={"User"},
     * @OA\Parameter(
     * description="Name of the user",
     * in="query",
     * name="name",
     * required=true,
     * @OA\Schema(
     * type="string"
     * )
     * ),
     * @OA\Parameter(
     * description="Firstname of the user",
     * in="query",
     * name="firstname",
     * required=true,
     * @OA\Schema(
     * type="string"
     * )
     * ),
     * @OA\Parameter(
     * description="Email of the user",
     * in="query",
     * name="email",
     * required=true,
     * @OA\Schema(
     * type="string"
     * )
     * ),
     * @OA\Parameter(
     * description="Password of the user",
     * in="query",
     * name="password",
     * required=true,
     * @OA\Schema(
     * type="string"
     * )
     * ),
     * @OA\Parameter(
     * description="Remember token of the user",
     * in="query",
     * name="remember_token",
     *  
     * @OA\Schema(
     * type="string"
     * )
     * ),
     * @OA\Parameter(
     * description="Api token of the user",
     * in="query",
     * name="api_token",
     * 
     * @OA\Schema(
     * type="string"
     * )
     * ),
     * @OA\Parameter(
     * description="Avatar of the user",
     * in="query",
     * name="avatar",
     *  
     * @OA\Schema(
     * type="string"
     * )
     * ),
     * @OA\RequestBody(
     * required=false,
     * description="example of the body request",
     * 
     * @OA\JsonContent(
     * 
     * @OA\Property(property="name", type="string", example="banos"),
     * @OA\Property(property="email", type="string", example="b@.Fr"),
     * @OA\Property(property="password", type="string", example="flodagnas54"),
     * @OA\Property(property="remember_token", type="string", example=""),
     * @OA\Property(property="api_token", type="string", example=""),
     * @OA\Property(property="avatar", type="string", example=""),
     * 
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="User created successfully",
     * @OA\JsonContent(
     * @OA\Property(property="code", type="integer", example="201"),
     * @OA\Property(property="msg", type="string", example="User created successfully"),
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Internal error",
     * @OA\JsonContent(
     * @OA\Property(property="code", type="integer", example="500"),
     * @OA\Property(property="error", type="string", example="Internal error"),
     * )
     * )
     * )
     * )
     *  
     * 
     */

    public function createUser(Request $request)
    {
        //http://localhost:8000/api/createuser?name=banos&email=banoslose@gmail.com&password=flodagnas54
        $validatedData = $request->validate([
            'name' => 'required|string',
            'firstname' => 'required|string',
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

     /**
      * @OA\Get(
        *  path="/api/checkSession",
        * summary="Check if the session is valid",
        * tags={"User"},
        * @OA\Parameter(
        * description="Cookie of the session",
        * in="query",
        * name="cookie",
        * required=true,
        * @OA\Schema(
        * type="string"
        * )
        * ),
        * @OA\Response(
        * response=201,
        * description="Session valid",
        * @OA\JsonContent(
        * @OA\Property(property="code", type="integer", example="201"),
        * @OA\Property(property="msg", type="string", example="Session valid"),
        * @OA\Property(property="user_id", type="integer", example="1"),
        * )
        * ),
        * @OA\Response(
        * response=400,
        * description="Session not found",
        * @OA\JsonContent(
        * @OA\Property(property="code", type="integer", example="400"),
        * @OA\Property(property="msg", type="string", example="Session not found"),
        * )
        * )
        * )
        * )
        *
      */

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
