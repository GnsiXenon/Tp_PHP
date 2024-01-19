<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ApiController extends Controller
{

/** @OA\Get(
*      path="/api",
*      operationId="api",
*      tags={"Endpoints"},
*      summary="Get list of endpoints",
*      description="Returns list of endpoints",
*      @OA\Response(
*          response=200,
*          description="Successful operation",
*          @OA\JsonContent()
*       ),
*      @OA\Response(
*          response=404,
*          description="No endpoints found",
*          @OA\JsonContent()
*       )
*     )
*/
public function getAllEndpoints()
{
    $routes = app()->routes->getRoutes();

    $endpoints = [];

    foreach ($routes as $route) {
        $endpoints[] = $route->uri();
    }

    return $endpoints;
}


public function readHeaderCookie()
{
    $headers = apache_request_headers();

    if (isset($headers['API_TOKEN'])) {
        // API token is present in the header
        // Check if the token is in the database
        $token = DB::table('session')->where('api-token', $headers['API_TOKEN'])->first();
        if ($token) {
            // Return the user id
            return [true , $token->user_id];
        } else {
            return [false ,'401','API token not authorized'];
        }
    } else {
        // API token is not present in the header
        return [false, '401','No API token found in the header'];
}

}
}